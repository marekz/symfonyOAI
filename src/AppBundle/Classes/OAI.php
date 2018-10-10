<?php

namespace AppBundle\Classes;

use Naoned\OaiPmhServerBundle\DataProvider\DataProviderInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAware;

class OAI extends ContainerAware implements DataProviderInterface
{

    public function __construct()
    {
    }

    /**
     * @return string Repository name
     */
    public function getRepositoryName()
    {
        // TODO: Implement getRepositoryName() method.
        return "KP Oai-Pmh Server";
    }

    /**
     * @return string Repository admin email
     */
    public function getAdminEmail()
    {
        // TODO: Implement getAdminEmail() method.
        return 'marek.zdybel@sbg.com.pl';
    }

    /**
     * @return \DateTime|string     Repository earliest update change on data
     */
    public function getEarliestDatestamp()
    {
        // TODO: Implement getEarliestDatestamp() method.
        return '1990-01-01';
    }

    /**
     * @param  string $identifier [description]
     * @return array
     */
    public function getRecord($id)
    {
        // TODO: Implement getRecord() method.
        $container = $this->container;
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();
        $record = $em->getRepository('AppBundle:Publications')->findOneBy(array('id'=>$id));
        return $this->convertToArray($record);

//        return array(
//            'title'         => 'Dummy content',
//            'description'   => 'Some more dummy content',
//            'sets'          => array('seta','setb'),
//        );
    }

    private function convertToArray($record){
        $recordArray = array(
            'identifier' => (string)$record->getId(),
            'title' => $record->getValue(),
            'description' => $record->getTitle(),
            'last_change' => $record->getCreatedAt(),
            'sets' => 'settest',
            'nr' => $record->getNr(),
            'source' => $record->getFilePAth()
        );
        return $recordArray;
    }

    /**
     * Search for records
     * @param  String|null $setTitle Title of wanted set
     * @param  \DateTime|null $from Date of last change «from»
     * @param  \DataTime|null $until Date of last change «until»
     * @return array|ArrayObject        List of items
     */
    public function getRecords($set = null, \DateTime $from = null, \DateTime $until = null)
    {
        // TODO: Implement getRecords() method.

        $container = $this->container;
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();
        $records = $em->getRepository('AppBundle:Publications')->findAll();
        $listIdentifiers = array();
        foreach ($records as $record) {
            $identifier = array(
                'identifier'  => $record->getId(),
                'title'       => $record->getValue(),
                'description' => $record->getTitle(),
                'last_change' => $record->getCreatedAt(),
                'source'      => $record->getFilepath(),
                'sets'        => array('seta', 'setb'),);
//            var_dump($record->getNr());
//            var_dump($record->getFilePath());
            $listIdentifiers[] = $identifier;
        }
        return $listIdentifiers;
//        return array(
//            array(
//                'identifier'  => '1W1',
//                'title'       => 'Dummy content 1',
//                'description' => 'Some more dummy content 1',
//                'last_change' => '2015-10-12',
//                'sets'        => array('seta', 'setb'),
//            ),
//            array(
//                'identifier'  => '1W2',
//                'title'       => 'Dummy content 2',
//                'description' => 'Some more dummy content 2',
//                'last_change' => '2015-10-12',
//                'sets'        => array('seta'),
//            ),
//            array(
//                'identifier'  => '1W3',
//                'title'       => 'Dummy content 3',
//                'description' => 'Some more dummy content 3',
//                'last_change' => '2015-10-12',
//                'sets'        => array('seta'),
//            ),
//            array(
//                'identifier'  => '1W4',
//                'title'       => 'Dummy content 4',
//                'description' => 'Some more dummy content 4',
//                'last_change' => '2015-10-12',
//                'sets'        => array('setc'),
//            ),
//            array(
//                'identifier'  => '1W5',
//                'title'       => 'Dummy content 5',
//                'description' => 'Some more dummy content 5',
//                'last_change' => '2015-10-12',
//                'sets'        => array('setd'),
//            ),
//        );
    }

    /**
     * must return an array of arrays with keys «identifier» and «name»
     * @return array List of all sets, with identifier and name
     */
    public function getSets()
    {
        // TODO: Implement getSets() method.
        return array(
            array(
                'identifier' => 'seta',
                'name'       => 'THE set number A',
            ),
            array(
                'identifier' => 'setb',
                'name'       => 'THE set identified by B',
            )
        );
    }

    /**
     * Tell me, this «record», in which «set» is it ?
     * @param  any $record An item of elements furnished by getRecords method
     * @return array         List of sets, the record belong to
     */
    public function getSetsForRecord($record)
    {
        // TODO: Implement getSetsForRecord() method.
        return $record['sets'];
    }

    /**
     * Transform the provided record in an array with Dublin Core, «dc_title»  style
     * @param  any $record An item of elements furnished by getRecords method
     * @return array         Dublin core data
     */
    public function dublinizeRecord($record)
    {
        // TODO: Implement dublinizeRecord() method.
        return array(
            'dc_identifier'     => $record['identifier'],
            'dc_title'          => $record['title'],
            'dc_description'    => $record['description'],
            'dc_source'         => $record['source'],
//            'dc_nr'             => $record['nr'],
//            'dc_filepath'       => $record['filepath'],
        );
    }

    /**
     * Check if sets are supported by data provider
     * @return boolean check
     */
    public function checkSupportSets()
    {
        // TODO: Implement checkSupportSets() method.
        return true;
    }

    /**
     * Get identifier of id
     * @param  any $record An item of elements furnished by getRecords method
     * @return string        Record Id
     */
    public static function getRecordId($record)
    {
        // TODO: Implement getRecordId() method.
        return $record['identifier'];
    }

    /**
     * Get last change date
     * @param  any $record An item of elements furnished by getRecords method
     * @return \DateTime|string     Record last change
     */
    public static function getRecordUpdated($record)
    {
        // TODO: Implement getRecordUpdated() method.
        return $record['last_change'];
    }
}