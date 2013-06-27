<?php
namespace Tecnotek\RetoAprenderBundle\Twig\Extensions;

class ResourcesMenuExtension extends \Twig_Extension
{
    private $em;
    private $conn;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        $this->conn = $em->getConnection();
    }

    public function getFunctions()
    {
        return array(
            'topics' => new \Twig_Function_Method($this, 'getTopics'),
            'levels' => new \Twig_Function_Method($this, 'getLevels'),
            'include_raw' => new \Twig_Function_Method($this, 'twig_include_raw'),
            //'include_raw' => new \Twig_Function_Function('twig_include_raw', array('needs_environment' => true)),
        );

        //$twig->addFunction('', new Twig_Function_Function());
    }

    public function getTopics()
    {
        $sql = "SELECT * FROM tek_topics ORDER BY name";
        return $this->conn->fetchAll($sql);
    }

    public function getLevels($topicId)
    {
        $sql = "SELECT * FROM tek_levels WHERE topic_id = $topicId ORDER BY name";
        return $this->conn->fetchAll($sql);
    }

    public function twig_include_raw($file) {
        return file_get_contents($file);
    }

    public function getFilters()
    {
        return array(
            'price' => new \Twig_Filter_Method($this, 'priceFilter'),
            'includePresentationFile' => new \Twig_Filter_Method($this, 'includePresentationFile'),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$' . $price;

        return $price;
    }

    public function getName()
    {
        return 'tecnotek_retoaprender_twig_extension';
    }
}