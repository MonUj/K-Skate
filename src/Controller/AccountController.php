<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
//use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\AccountType;
use App\Service\FileUploader;

class AccountController extends AbstractController
{
    /**
     * @Route("/monespace", name="app_monespace")
     */
    public function index(Request $request, UserRepository $user) : Response  //ObjectManager $manager,
    {
        $user = $this->getUser();
        $currentAvatar = $user->getAvatar();

        if(!empty($currentAvatar))
        {
            $avatarPath = ($this->getParameter('avatar_directory'). DIRECTORY_SEPARATOR . $user->getAvatar());
            //$user->setAvatar(new File($avatarPath));
        }

        $formUpdateUser = $this->createForm(AccountType::class, $user);
        $formUpdateUser->handleRequest($request);

        //dump($currentAvatar);
        if ($formUpdateUser->isSubmitted() && $formUpdateUser->isValid())
        {
            $avatar = $user->getAvatar();

            if (!is_null($avatar))
            {
                //$file = $user->getAvatar();
                $file = $formUpdateUser->get('avatar')->getData();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move($this->getParameter('avatar_directory'), $fileName);
                $user->setAvatar($fileName);
            }
            else
            {
                $user->setAvatar($currentAvatar);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Modification enregistré.');
            return $this->redirectToRoute('app_home');
        }



        return $this->render('account/account.html.twig', ['formUpdateUser'=> $formUpdateUser->createView(), 'user' => $user, 'avatar' => $currentAvatar]);
    }



    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}