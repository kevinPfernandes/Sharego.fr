<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Job;
use AppBundle\Repository\JobRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Reponse;


class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(JobRepository $jobRepository,ArticleRepository $articleRepository)
    {
        return $this->render('home/index.html.twig', [
            "articles"=> $articleRepository->articlehome(),
            "jobs"=>$jobRepository->Jobhome(),
        ]);
    }


    public function searchBarAction(Request $request)
    {
        $form=$this->createFormBuilder()
            ->add('search',TextType::class)->getForm();
        return $this->render('home/index.html.twig',[
            'form'=>$form->createView()
            ]);

    }

    /**
     * @Route("/articles", name="article")
     */
    public function article (ArticleRepository $articleRepository)
    {
        return $this->render('home/article.html.twig', [
            "articles"=> $articleRepository->articlehome(),
        ]);
    }

    /**
     * @Route("/jobs", name="jobs")
     */
    public function job (JobRepository $jobRepository)
    {
        return $this->render('home/job.html.twig', [
            "jobs"=>$jobRepository->Jobhome(),
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articlesid")
     */

    public function showArticle($id)
    {
        $article = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->find($id);
        $users = $article->getUsers();

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $this->render('home/showArticle.html.twig', array(
            'article'      => $article,
            'user'=>$users
        ));
    }

    /**
     * @Route("/jobs/{id}", name="jobsid")
     */

    public function showJob($id)
    {
        $job = $this->getDoctrine()
            ->getRepository('AppBundle:Job')
            ->find($id);
        $user = $job->getUsers();

        if (!$job) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $this->render('home/showJob.html.twig', array(
            'job'      => $job,
            'user'=>$user
        ));
    }






}
