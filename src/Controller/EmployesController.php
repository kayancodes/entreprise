<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployesController extends AbstractController
{

    //----- DEBUT READ -----------------------------------------------------------------------//

    //------AFFICHAGE DE TOUT LES ELEMENTS DE LA TABLE EMPLOYES
    /** 
     * @Route("employes", name="employes_list")
     */                     //autowire ou autowiring
     public function employesList(EmployesRepository $employesRepository){
         $employes = $employesRepository->findAll();
         
         return $this->render("employes_list.html.twig", ['employes' => $employes]);
     }


    //------AFFICHAGE D'UN ELEMENTS DE LA TABLE EMPLOYES
    /** 
     * @Route("employe/{id}", name="employe_show")
     */                     //autowire ou autowiring
     public function employeShow(EmployesRepository $employesRepository, $id){

         $employe = $employesRepository->find($id);

         return $this->render("employe_show.html.twig", ['employe' => $employe]);
     }

    //----- FIN READ -----------------------------------------------------------------------//





    //----- DEBUT UPDATE -----------------------------------------------------------------------//

    //------MODIFICATION D'UN EMPLOYE
    /** 
     * @Route("update/employe/{id} ", name="employe_update")
     */  

     public function employeUpdate(
         $id, 
         EmployesRepository $employesRepository, 
         EntityManagerInterface $entityManagerInterface,
         Request $request
         ){

            $employe = $employesRepository->find($id);

            //creation du formulaire
            $employeForm = $this->createForm(EmployesType::class, $employe);

            //handleRequest permet de recuperer les informations rentres
            $employeForm->handleRequest($request);

            if($employeForm->isSubmitted() && $employeForm->isValid()){

                //la fonction persist() va regarder ce que l'on a fait sur employe
                //et realiser le code pour faire le CREATE ou le UPDATE
                $entityManagerInterface->persist($employe);
                //La fonction flush()permet de tout enregistrer dans la BDD
                $entityManagerInterface->flush();

                return $this->redirectToRoute("employes_list");
            }

            return $this->render('employe_form.html.twig', ['employeForm' => $employeForm->createView()]);
     }
    //----- FIN UPDATE --------------------------------------------------------------------------//


    
    //----- DEBUT CREATE -----------------------------------------------------------------------//
    //------CREATION D'UN EMPLOYE
    /**
     * @Route("create/employe", name="employe_create")
     */

     public function employeCreate(
         EntityManagerInterface $entityManagerInterface,
         Request $request
     ){
         $employe = new Employes();

            //creation du formulaire
            $employeForm = $this->createForm(EmployesType::class, $employe);

            //handleRequest permet de recuperer les informations rentres
            $employeForm->handleRequest($request);

            if($employeForm->isSubmitted() && $employeForm->isValid()){

                //la fonction persist() va regarder ce que l'on a fait sur employe
                //et realiser le code pour faire le CREATE ou le UPDATE
                $entityManagerInterface->persist($employe);
                //La fonction flush()permet de tout enregistrer dans la BDD
                $entityManagerInterface->flush();

                return $this->redirectToRoute("employes_list");
            }

            return $this->render('employe_form.html.twig', ['employeForm' => $employeForm->createView()]);         


     }


    //----- FIN CREATE -------------------------------------------------------------------------//






    //----- DEBUT DELETE -----------------------------------------------------------------------//
    //------SUPPRESSION D'UN EMPLOYE


    /**
     * @Route("delete/employe/{id}", name="delete_employe")
     */

     public function deleteEmploye(
         $id,
         EntityManagerInterface $entityManagerInterface,
         EmployesRepository $employesRepository
     ){
         $employe = $employesRepository->find($id);

         //la fonction remove() supprime le poste
         $entityManagerInterface->remove($employe);
         $entityManagerInterface->flush();

         return $this->redirectToRoute('employes_list');
     }
    //----- FIN DELETE -------------------------------------------------------------------------//














}
