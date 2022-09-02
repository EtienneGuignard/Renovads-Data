<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {



        return $this->render('profile/index.html.twig', [
        ]);
    }

    #[Route('/profile/edit/{id}', name: 'app_profile_edit')]
    public function editProfile(
    Request $request, 
    UserPasswordHasherInterface $userPasswordHasher, 
    UserAuthenticatorInterface $userAuthenticator, 
    LoginAuthenticator $authenticator,
    EntityManagerInterface $entityManagerInterface,
    UserRepository $userRepository
    ): Response
    {

        $user = new User;
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $id=$user->getId();
        $email=$user->getEmail();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        //check submit  and valid from
            
        if($form->isSubmitted() && $form->isValid()){
            $newEmail=$user->getEmail();
        
            if ($this->isEmailExist($newEmail, $userRepository)===false || $newEmail == $email )  {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );

            $this->updateUser($entityManagerInterface, $user);
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }else{
            return $this->redirectToRoute('app_profile');
        }
    }

        return $this->render('profile/editProfile.html.twig', [
            'form' => $form->createView(),
            'id'=>$id
        ]);
    }  
    public function updateUser( EntityManagerInterface $entityManagerInterface,
        User $user,)
        {
            $entityManagerInterface->flush();
        }

    public function isEmailExist(string $emailUser,
    UserRepository $userRepository): bool
    {
        // search for an existing email in db
        $emailInDB= $userRepository->findOneBy(['email' => $emailUser]);

        if (!empty($emailInDB)) {
            return true;
        }
        return false;
    }
}
