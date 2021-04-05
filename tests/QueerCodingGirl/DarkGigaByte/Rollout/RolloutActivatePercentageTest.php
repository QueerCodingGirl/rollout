<?php

class RolloutActivatePercentageTest extends \PHPUnit_Framework_TestCase {


    /**
     * @dataProvider activatePercentageProvider
     * @covers QueerCodingGirl\Rollout\RolloutAbstract::activatePercentage
     */
    public function testActivatePercentage($percentage)
    {
        $feature = $this->getMockBuilder('\QueerCodingGirl\Rollout\Feature\CoreFeature')
            ->disableOriginalConstructor()
            ->setMethods(array('setPercentage'))
            ->getMock();

        $feature->expects($this->once())
            ->method('setPercentage')
            ->with($this->equalTo($percentage));

        $rollout = $this->getMockBuilder('\QueerCodingGirl\Rollout\Rollout')
            ->disableOriginalConstructor()
            ->setMethods(array('getFeature', 'saveFeature'))
            ->getMock();

        $rollout->expects($this->once())
            ->method('getFeature')
            ->with($this->equalTo('test'))
            ->will($this->returnValue($feature));

        $rollout->expects($this->once())
            ->method('saveFeature')
            ->with($this->equalTo($feature));

        $rollout->activatePercentage('test', $percentage);
    }

    public function activatePercentageProvider()
    {
        return array(
            array(40),
            array(50),
            array(1),
            array(0)
        );
    }
}
 