<?php

namespace Shareexo\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shareexo\Helpers\ArrayToString;
use Shareexo\Helpers\Hash;
use Shareexo\Helpers\UploadImage;
use Shareexo\History\History;
use Shareexo\History\QuestionHistory;
use Shareexo\Models\Question;
use Shareexo\Rmail\Rmail;
use Shareexo\Validation\Contracts\ValidatorInterface;
use Shareexo\Validation\Forms\QuestionForm;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;

use function DI\get;

class QuestionController{

    public function get($slug, ServerRequestInterface $request, ResponseInterface $response, Question $question, Twig $view, Router $router, History $history){

        $question = $question->where('slug', $slug)->first();
        $solutions = $question->solutions()->get();
        $images = $question->images()->get();      

        if(!$question){
            return $response->withRedirect($router->pathFor('home'));
        }

        return $view->render($response, 'questions/question.twig', [
            'history' => $history->all_history(),
            'question' => $question,
            'solutions' => $solutions,
            'images' => $images
        ]);

    }

    public function new(ServerRequestInterface $request, ResponseInterface $response, Twig $view, History $history){  
        
        return $view->render($response, 'questions/new.twig', [
            'history' => $history->all_history()
        ]);

    }

    protected function new_link(ServerRequestInterface $request):string{
        $header = $request->getServerParams()['HTTP_REFERER'];
        $header_parts = explode('/', $header);

        return 'http://' . $header_parts[2].'/'.$header_parts[3].'/';
    }

    public function create(Rmail $mail, ServerRequestInterface $request, ResponseInterface $response, Router $router, ValidatorInterface $validator, Question $question, QuestionHistory $question_history, Messages $flash){

        $hash = Hash::slug();

        $validator = $validator->validate($request, QuestionForm::rules());

        if($validator->fails()){
            return $response->withRedirect($router->pathFor('question.new'));
        }

        $question = $question->firstOrCreate([
            'username' => $request->getParam('name'),
            'useremail' => $request->getParam('email'),
            'subject' => $request->getParam('subject'),
            'description' => $request->getParam('description'),
            'slug' => $hash,
            'link' => $this->new_link($request).$hash
        ]);

        if(!empty($request->getUploadedFiles())){
            $uploads = $request->getUploadedFiles();
            foreach($uploads['image'] as $upload){
                if($upload->getError() === UPLOAD_ERR_OK){
                    $filename = UploadImage::moveUploadedFile($upload);
                }
                $question->images()->create([
                    'name' => $filename
                ]);
            }
        }
        
        if($request->getParam('copy') == 'on'){
            $mailMessage = json_decode($question, true);
            $excludes = ['slug', 'updated_at', 'id'];
            $mailMessage = ArrayToString::transform($mailMessage, $excludes);
            $mail->send(
                $request,
                'Thanks for using Shareexo. Just be patient someone will help you soon.'.PHP_EOL.
                PHP_EOL.
                $mailMessage.PHP_EOL.
                PHP_EOL.
                'Contact Us on Facebook, Email, Instagram'
            );
        }
        
        $question = json_encode($question, JSON_FORCE_OBJECT);
        $question_history->add($question);

        $flash->addMessage('question', 'Question uploaded successfully');

        return $response->withRedirect($router->pathFor('home'));

    }

}