<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new PointWeb\AppBundle\PointWebAppBundle(),
            new PointWeb\AdminBundle\PointWebAdminBundle(),
            new PointWeb\UserBundle\PointWebUserBundle(),
            new PointWeb\NewsBundle\PointWebNewsBundle(),
            new PointWeb\PartnerBundle\PointWebPartnerBundle(),
            new PointWeb\GuestBookBundle\PointWebGuestBookBundle(),
            new PointWeb\GedBundle\PointWebGedBundle(),
            new PointWeb\FaqBundle\PointWebFaqBundle(),
            new PointWeb\ProductBundle\PointWebProductBundle(),
            new PointWeb\CalendarBundle\PointWebCalendarBundle(),
            new PointWeb\ReferencingBundle\PointWebReferencingBundle(),
            new PointWeb\NewsletterBundle\PointWebNewsletterBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
