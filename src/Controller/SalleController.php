<?php
    namespace App\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Entity\Salle;

    class SalleController extends AbstractController {
        public function accueil() {
            $nombre = rand(1,84);
            return $this->render('salle/accueil.html.twig',array('numero' => $nombre)); // ou ['numero'=>$nombre]);
        }
        public function afficher($numero) {
            if ($numero > 50)
                throw $this->createNotFoundException('c\'est trop'); // Il est préférable que l’utilisateur soit informé et renvoyé vers l’accueil 
            else
                return $this->render('salle/afficher.html.twig',array( 'numero' => $numero ));
        }
        public function dix() {
            return $this->redirectToRoute('salle_tp_afficher', array('numero' => 10));
        }
        public function treize() {
            $salle=new Salle;
            $salle->setBatiment("D");
            $salle->setEtage(1);
            $salle->setNumero(13);
            return $this->render('salle/treize.html.twig',array('salle'=>$salle));
        }
        public function quatorze() {
            $salle=new Salle;
            $salle->setBatiment("D");
            $salle->setEtage(1);
            $salle->setNumero(14);
            return $this->render('salle/quatorze.html.twig',array('designation'=>$salle->__toString()));
        }
        
        public function voir($id) {
            $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
            if(!$salle) throw $this->createNotFoundException('Salle[id='.$id.'] inexistante');
            return $this->render('salle/voir.html.twig',array('salle' => $salle));
        }
        
        public function ajouter($batiment, $etage, $numero) {
            $entityManager = $this->getDoctrine()->getManager();
            $salle = new Salle;
            $salle->setBatiment($batiment);
            $salle->setEtage($etage);
            $salle->setNumero($numero);
            $entityManager->persist($salle);
            $entityManager->flush();
            return $this->redirectToRoute('salle_tp_voir',array('id' => $salle->getId()));
        }
    }
?>