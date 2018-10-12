<?php

namespace AppBundle\Classes;

use Naoned\OaiPmhServerBundle\DataProvider\DataProviderInterface;
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
        return $this->container->getParameter('repository_name');
    }

    /**
     * @return string Repository admin email
     */
    public function getAdminEmail()
    {
        return $this->container->getParameter('repository_admin');
    }

    /**
     * @return \DateTime|string     Repository earliest update change on data
     */
    public function getEarliestDatestamp()
    {
        return $this->container->getParameter('earliest_datestamp');
    }

    /**
     * @param  string $identifier [description]
     * @return array
     */
    public function getRecord($id)
    {
        $container = $this->container;
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();
        $record = $em->getRepository('AppBundle:Publications')->findOneBy(array('id'=>$id));

        return $this->convertToArray($record);
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
        $container = $this->container;
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();
        $records = $em->getRepository('AppBundle:Publications')->findAll();
        $listIdentifiers = array();
        foreach ($records as $record) {
            $identifier = array(
                'identifier'  => $record->getId(),
                'title'       => $record->getTitle(),
                'description' => $record->getNr(),
                'last_change' => $record->getCreatedAt(),
                'source'      => $record->getFilepath(),
                'sets'        => array($record->getValue()),);
            $listIdentifiers[] = $identifier;
        }
        return $listIdentifiers;
    }

    /**
     * must return an array of arrays with keys «identifier» and «name»
     * @return array List of all sets, with identifier and name
     */
    public function getSets()
    {
        $container = $this->container;
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();
        $records = $em->getRepository('AppBundle:Publications')->getSetsRecords();

        $sets_array = array();

        foreach($records as $record) {
            array_push(
                $sets_array,
                array(
                    'identifier'=>$this->specValue($record['value']),
                    'name'=>$record['value']
                )
            );
        }

        return $sets_array;
    }

    private function specValue($value){
        if($value == "Zeszyty Historyczne") return "ZH";
        if($value == "Miesięcznik Kultura") return "MK";
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