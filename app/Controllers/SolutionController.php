<?php

namespace Shareexo\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shareexo\Helpers\ArrayToString;
use Shareexo\Helpers\Hash;
use Shareexo\Helpers\UploadImage;
use Shareexo\History\History;
use Shareexo\History\SolutionHistory;
use Shareexo\Models\Question;
use Shareexo\Models\Solution;
use Shareexo\Rmail\Rmail;
use Shareexo\Validation\Contracts\ValidatorInterface;
use Shareexo\Validation\Forms\SolutionForm;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;

class SolutionController{

    protected function new_link(ServerRequestInterface $request):string{
        $header = $request->getServerParams()['HTTP_REFERER'];
        $header_parts = explode('/', $header);

        return 'http://' . $header_parts[2].'/'.$header_parts[3].'/';
    }

    public function get($slug, ServerRequestInterface $request, ResponseInterface $response, Twig $view, Solution $solution){
        $solution = $solution->where('slug', $slug)->first();
        $images = $solution->images()->get();

        return $view->render($response, 'solutions/solution.twig', [
            'history' => History::class,
            'solution' => $solution,
            'images' => $images
        ]);
    }

    public function new($slug, Question $ques, ServerRequestInterface $request, ResponseInterface $response, ?Twig $view){

        // $slug = GetQuestionSlug::getslug($request);

        $question = $ques->where('slug', $slug)->first();
        $slug = $question->slug;
        $_SESSION['question_slug'] = $slug;

        return $view->render($response, 'solutions/new.twig', [
            'history' => History::class,
            'question_slug' => $slug
        ]);
    }

    public function create(Rmail $mail, ServerRequestInterface $request, ResponseInterface $response, Router $router, ValidatorInterface $validator, Question $question, Solution $solution, SolutionHistory $solution_history, Messages $flash){

        $hash = Hash::slug();

        $slug = $_SESSION['question_slug'];

        $question = $question->where('slug', $slug)->first();

        $validator = $validator->validate($request, SolutionForm::rules());

        if($validator->fails()){
            return $response->withRedirect($router->pathFor('solution.new', ['slug' => $slug], []));
        }

        //Condition to insert solutions values
        $solution = $solution->firstOrCreate([
            'username' => $request->getParam('name'),
            'useremail' => $request->getParam('email'),
            'description' => $request->getParam('description'),
            'slug' => $hash,
            'link' => $this->new_link($request).$hash,
        ]);
        
        //Save solution for question
        $question->solutions()->save($solution);

        //Upload images
        if(!empty($request->getUploadedFiles())){
            $uploads = $request->getUploadedFiles();
            foreach($uploads['image'] as $upload){
                if($upload->getError() === UPLOAD_ERR_OK){
                    $filename = UploadImage::moveUploadedFile($upload);
                }
                $solution->images()->create([
                    'name' => $filename
                ]);
            }
        }

        //Sending Email
        if($request->getParam('copy') == 'on'){
            $mailMessage = json_decode($solution, true);
            $excludes = ['slug', 'updated_at', 'id', 'question_id'];
            $mailMessage = ArrayToString::transform($mailMessage, $excludes);
            $mail->send(
                $request,
                'Thanks for helping others with their school exercises'.PHP_EOL.
                PHP_EOL.
                $mailMessage.PHP_EOL.
                PHP_EOL.
                'Contact Us on Facebook, Email, Instagram'
            );
        }

        //Save in history
        $solution = json_encode($solution, JSON_FORCE_OBJECT);
        $solution_history->add($solution);

        $flash->addMessage('solution', 'Solution uploaded successfully');

        return $response->withRedirect($router->pathFor('home'));
    }

}