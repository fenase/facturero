<?php
/**
 * Defines the suit of tests to perform on the code view SimpleTest
 *
 * PHP Version 5
 *
 * @created 05/14/2013
 * @updated 05/15/2013
 *
 * @category   UnitTests
 * @package    UnitTests
 * @author     Mike Kromarek <mkromarek@highline.edu>
 * @license    http://lic.org/lic.php  HCC
 * @version    $Revision$
 * @link       /structureExample/tests/simpletest/TestSuite.php SimpleTest Test Suite
 */

/**
 * Include the simpletest file so we can extend TestSuite
 */
require_once 'simpletest/simpletest.php';
require_once 'simpletest/unit_tester.php';
/**
 * Include the JUnitXMLReporter class so the output is jUnit and xUnit compatible
 */
require_once 'simpletest/extensions/junit_xml_reporter.php';


/**
 * Defines the test suit called MyTests that performs all of the tests in the
 * files added to it. The class is defined this was so the output is
 * correct (no footer or header, just xml)
 *
 * @category   UnitTests
 * @package    UnitTests
 * @author     Mike Kromarek <mkromarek@highline.edu>
 * @license    http://lic.org/lic.php  HCC
 * @version    $Revision$
 * @link       /structureExample/tests/simpletest/TestSuite.php SimpleTest Test Suite
 */
class MyTests extends TestSuite
{
    function __construct()
    {
        parent::__construct();
        
        //add the files containing the tests we want to perform
        //not the use of __DIR__ so we don't have to worry about file location
        //when running the tests in Jenkins
        $this->addFile(dirname(__FILE__).'/Test.php');
    }
    
}

$test = new MyTests();
$test->run(new JUnitXMLReporter());

