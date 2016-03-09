<?php

namespace PointWeb\AppBundle\Controller;

use PointWeb\AppBundle\Entity\Contact;
use PointWeb\AppBundle\Entity\ContactMail;
use PointWeb\AppBundle\Form\ContactType;
use PointWeb\AppBundle\Form\ContactMailType;
use PointWeb\AppBundle\Sitemap\Url;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
       $status = 0;

        $entity = new ContactMail();
        $form = $this->createForm(new ContactMailType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer', 'attr' => array('class' => 'btn btn-info waves-effect waves-light')));
        $form->handleRequest($request);

        if ($form->isValid()) {
           
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande de contact site')
                    ->setFrom($this->container->getParameter('mail_to'))
                    ->setTo($this->container->getParameter('mail_to'))
                    ->setBody($this->renderView('PointWebAppBundle:Mail:contactmail.txt.twig', array(
                        'entity' => $entity
                    )));
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('point_web_app_thanks'));
            }
       
           if ($status == 0) {
            return $this->render('PointWebAppBundle:Default:index.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
    }
      
            return $this->render('PointWebAppBundle:Default:index.html.twig');
    }
    public function creationAction(Request $request)
    {
       $status = 0;

        $entity = new ContactMail();
        $form = $this->createForm(new ContactMailType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer', 'attr' => array('class' => 'btn btn-info waves-effect waves-light')));
        $form->handleRequest($request);

        if ($form->isValid()) {
           
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande de contact site')
                    ->setFrom($this->container->getParameter('mail_to'))
                    ->setTo($this->container->getParameter('mail_to'))
                    ->setBody($this->renderView('PointWebAppBundle:Mail:contactmail.txt.twig', array(
                        'entity' => $entity
                    )));
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('point_web_app_thanks'));
            }
       
           if ($status == 0) {
            return $this->render('PointWebAppBundle:Default:creation.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
    }
      
            return $this->render('PointWebAppBundle:Default:creation.html.twig');
    }


 public function asideAction(Request $request = null)
    {
        $status = 0;

        $entity = new ContactMail();
        $form = $this->createForm(new ContactMailType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer', 'attr' => array('class' => 'btn btn-info waves-effect waves-light')));
        $form->handleRequest($request);

        if ($form->isValid()) {
           
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande de contact site')
                    ->setFrom($this->container->getParameter('mail_to'))
                    ->setTo($this->container->getParameter('mail_to'))
                    ->setBody($this->renderView('PointWebAppBundle:Mail:contactmail.txt.twig', array(
                        'entity' => $entity
                    )));
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('point_web_app_thanks'));
            }
       
           if ($status == 0) {
            return $this->render('PointWebAppBundle::_aside.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
    }
}


    public function legalAction()
    {
        return $this->render('PointWebAppBundle:Default:legal.html.twig');
    }

    public function footerAction()
    {
        $date = new \DateTime();
        return $this->render('PointWebAppBundle::_footer.html.twig', array('date' => $date));
    }

    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('PointWebAdminBundle:Menu')->findBy(
            array('parent' => null),
            array('position' => 'ASC')
        );
        return $this->render('PointWebAppBundle::_menu.html.twig', array(
            'menus' => $menus
        ));
    }


    /**
     * Page Contact
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $status = 0;
        $questions = $this->captcha();

        $entity = new Contact();
        $form = $this->createForm(new ContactType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer','attr' => array('class' => 'btn btn-info waves-effect waves-light')));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $reponse = $request->get('captcha');
            if (in_array($reponse, $questions[$request->getSession()->get('id_question')]['reponse'])) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Devis Client')
                    ->setFrom($this->container->getParameter('mail_to'))
                    ->setTo($this->container->getParameter('mail_to'))
                    ->setBody($this->renderView('PointWebAppBundle:Mail:contact.txt.twig', array(
                        'entity' => $entity
                    )));
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('point_web_app_thanks'));
            }
        }


        $request->getSession()->set('id_question', array_rand($questions, 1)); //je genere une question aléatoire

        if ($status == 0) {
            return $this->render('PointWebAppBundle:Default:contact.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
                'question' => $questions[$request->getSession()->get('id_question')]['question'],
                'captcha' => $request->get('captcha') ? $request->get('captcha') : ""
            ));
        }
    }
    public function realisationAction(Request $request)
    {
      $status = 0;

        $entity = new ContactMail();
        $form = $this->createForm(new ContactMailType(), $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer', 'attr' => array('class' => 'btn btn-info waves-effect waves-light')));
        $form->handleRequest($request);

        if ($form->isValid()) {
           
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Demande de contact site')
                    ->setFrom($this->container->getParameter('mail_to'))
                    ->setTo($this->container->getParameter('mail_to'))
                    ->setBody($this->renderView('PointWebAppBundle:Mail:contactmail.txt.twig', array(
                        'entity' => $entity
                    )));
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('point_web_app_thanks'));
            }
       
           if ($status == 0) {
            return $this->render('PointWebAppBundle:Default:realisation.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
    }
        return $this->render('PointWebAppBundle:Default:realisation.html.twig');
    }
    public function thanksAction()
    {
        return $this->render('PointWebAppBundle:Default:thanks.html.twig');
    }

    public function cookiesAction()
    {
        return $this->render('PointWebAppBundle:Default:cookies.html.twig');
    }

    /**
     * return the sitemeap with out xml encoding
     */
    public function sitemapAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        //on liste l'ensemble des slugs qui sont utilise dans les routes du style {slug}|{slug}|{slug}.....
        $pattern = "/{/";

        $url = new Url();
        $url->setLastmod("15/10/2015");
        $url->setPriority('0.5');

        //on stocke les url simple sans slug
        $urlArray = $this->getUrl($url, $pattern);

        //on recupere les bundle qui contiennent des urls avec slug
        $routeAction = $this->getPathSlug($url, $pattern);

        //on stocke les url avec slug
        $urlArray2 =  $this->getSlugUrl($url, $em, $routeAction);
        $list = array_merge($urlArray, $urlArray2);



        return $this->render('PointWebAppBundle:Default:sitemap.html.twig', array('urls' => $list));
    }

    /**
     * return sitemap with xml encoding
     */

    public function sitemapXmlAction()
    {

        $em = $this->getDoctrine()->getEntityManager();

        //on liste l'ensemble des slugs qui sont utilise dans les routes du style {slug}|{slug}|{slug}.....
        $pattern = "/{/";

        ///initialisation du serializer
        $encoders = array(new XmlEncoder('urlset'), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);


        // classe URL qui permet de definir une l'url, la priorite et la date de derniere modif

        $url = new Url();
        $url->setLastmod("15/10/2015");
        $url->setPriority('0.5');

        //on stocke les url simple sans slug
        $urlArray = $this->getUrl($url, $pattern);

        //on recupere les bundle qui contiennent des urls avec slug
        $routeAction = $this->getPathSlug($url, $pattern);

        //on stocke les urls avec slug
        $urlArray2 =  $this->getSlugUrl($url, $em, $routeAction);

        //on affiche
        $list['url'] = array_merge( $urlArray, $urlArray2);


        $response = new Response();
        $response->setContent($serializer->serialize($list, 'xml'));
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }

    /**
     * @param Url $url entité URL from Sitemap/URL
     * @param $pattern regex utilisée pour filtrer les urls
     * @param $key ( 1 pour les url avec slug )
     *
     * @return array tableau d'url
     */
    private function getUrl(Url $url, $pattern, $key = 0)
    {
        //liste des bundles inutilisés
        $bundleToAvoid = array('sitemap.xml', 'cookies', 'profile');

        //retourne un tableau avec toutes les url de tout les bundles
        $routes = $this->getAllRoutes();

        //ce tableau contient la liste des url sans slug
        $tabUrl = array();

        //Parcours la liste de toute les routes et stocke celles qui n'ont pas de {slug}
        foreach ($routes as $rte) {

            $path = explode('/', $rte->getPath());
            $bundle = strtolower($path[1]);

            //on ignore toutes les routes des bundles lister dans le tableau $bundleToAvoid
            if(!in_array($bundle, $bundleToAvoid)) {
                //on verifie si notre route ne contient pas de slug
                if ($key == 0) {
                    if (!preg_match($pattern, $rte->getPath())) {
                        $url->setLoc($this->getRequest()->getHost() . "" . $rte->getPath());
                        $tabUrl[] = array('loc' => $url->getLoc(), 'lastmod' => $url->getLastmod(), 'changefreq' => 'weekly', 'priority' => $url->getPriority());
                    }
                } elseif ($key == 1) {
                    if (preg_match($pattern, $rte->getPath())) {
                        $url->setLoc($this->getRequest()->getHost() . "" . $rte->getPath());
                        $tabUrl[] = array('loc' => $url->getLoc(), 'lastmod' => $url->getLastmod(), 'changefreq' => 'weekly', 'priority' => $url->getPriority());
                    }
                }
            }
        }
        return $tabUrl;
    }

    /**
     * @param Url $url
     * @param $pattern
     * @return array retourne un tableau associatif entité et slug
     */
    private function getPathSlug(Url $url, $pattern)
    {
        $urlTab = $this->getUrl($url, $pattern, 1);
        $tabFinal = array();

        foreach ($urlTab as $tab) {

            $urlExplode = explode('/', $tab['loc']);
            $entity = null;
            $slugA = null;
            if (strstr(end($urlExplode), '{') == false) {
                $action = end($urlExplode);
            } else {
                $action = '';
            }

            foreach ($urlExplode as $ex) {

                if (strstr($ex, '{') != false) {
                    $slug = str_replace('{', ' ', $ex);
                    $slug = str_replace('}', ' ', $slug);
                    $slugA[] = $slug;

                } elseif (strstr($ex, 'www') == false AND strstr($ex, '{') == false AND $ex != $action) {
                    if ($action != '')                                   //format{ www.test.fr/Product/{slug}/{slug}/show} => path = Product_show
                        $entity = ucfirst($ex) . '_' . $action;
                    else                                                //format{ www.test.fr/Product/{slug}/{slug} => path = Product
                        $entity = ucfirst($ex);
                }


            }

            $tabFinal[] = array('entity' => $entity, 'slug' => $slugA);
        }
        return $tabFinal;
    }

    /**
     * @param Url $url
     * @param $em
     * @param $routeAction tableau qui contient la liste des routes des avec slug
     *
     * @return array
     */
    private function getSlugUrl(Url $url, $em, $routeAction)
    {
        //ce tableau va stocker toute nos urls
        $urls = array();

        //ce tableau contient la liste des bunndles a ignorés
        $bundleToAvoid = array();

        //on parcours le tableau d'entite
        foreach ($routeAction as $rt) {
            $name = explode("_", $rt['entity']);
            $tmp = $name[0];
            $entityName = $bundleName = ucfirst($tmp);

            if ($bundleName == 'Category') {
                $bundleName = 'Product';
            }

            //si le nom de bundle n'est pas dans le tableau des bundle a pas afficher alors on le traite !!
            if (!in_array(strtolower($bundleName), $bundleToAvoid)) {
                foreach ($em->getRepository('PointWeb' . $bundleName . 'Bundle:' . $entityName)->findAll() as $rs) {

                    //on parcours le tableau de slug
                    $param = array();
                    foreach ($rt['slug'] as $slug) {
                        //$param = $slug ." => ". $rs->{'get' . ucfirst(trim($slug))}();
                        $param = array(trim($slug) => $rs->{'get' . ucfirst(trim($slug))}());

                    }

                    $path = $this->get('router')->generate(strtolower($rt['entity']), $param);
                    $url->setLoc($this->getRequest()->getHost() . "" . $path);
                    $urls[] = array('loc' => $url->getLoc(), 'lastmod' => $url->getLastmod(), 'changefreq' => 'weekly', 'priority' => $url->getPriority());

                }
            }

        }

        return $urls;
    }

    public function getAllRoutes($prefix = null)
    {
        if (is_string($prefix)) $pattern = '/^\/' . $prefix . '/';
        else $pattern = '/.*/';
        $this->allRoutes = array();
        foreach ($this->get('router')->getRouteCollection()->all() as $nom => $route) {
            if (preg_match($pattern, $route->getPath()) && !preg_match('/^\/admin\//', $route->getPath()) && !preg_match('/^\/_/', $route->getPath()) && !preg_match('/^\/register\//', $route->getPath()) && !preg_match('/^\/resetting\//', $route->getPath())) {
                $this->allRoutes[$nom] = $route;
            }
        }
        return $this->allRoutes;
    }

    /**
     * @return array
     * retourne un tableau de questions et de reponses pour le captcha
     */
    public function captcha()
    {
        //je créer un tableau de questions avec les réponses possibles
        $questions =
            array(
                "q1" => array('question' => "Combien font 1 + 1 ?",
                              'reponse'  => array('2', 'deux', 'DEUX')
                ),

                "q2" => array('question' => "Quelle est la première lettre du mot \"Contact\" ?",
                              'reponse'  => array('c', 'C')
                ),

                "q3" => array('question' => "Quelle est la couleur du feu rouge ?",
                              'reponse'  => array('rouge', 'ROUGE', 'red')
                ),

                "q4" => array('question' => "Quelle est la première lettre de l'alphabet Français ?",
                    'reponse'  => array('a', 'A')
                ),

            );

        return $questions;
    }

}
