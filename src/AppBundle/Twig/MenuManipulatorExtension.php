<?php
namespace AppBundle\Twig;

use Knp\Menu\Util\MenuManipulator;
use Knp\Menu\ItemInterface;

class MenuManipulatorExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [new \Twig_SimpleFunction('menu_manipulator', [$this, 'menuManipulator'])];
    }

    public function menuManipulator(ItemInterface $item)
    {
        return (new MenuManipulator())->getBreadcrumbsArray($item);
    }

    public function getName()
    {
        return 'menu_manipulator';
    }
}