<?php

class RolloutDeactivatePercentageTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers DarkGigaByte\Rollout\RolloutAbstract::deactivatePercentage
     */
    public function testDeactivatePercentage()
    {
        $feature = $this->getMockBuilder('\DarkGigaByte\Rollout\Feature\CoreFeature')
            ->disableOriginalConstructor()
            ->setMethods(array('setPercentage'))
            ->getMock();

        $feature->expects($this->once())
            ->method('setPercentage')
            ->with($this->equalTo(0));

        $rollout = $this->getMockBuilder('\DarkGigaByte\Rollout\Rollout')
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

        $rollout->deactivatePercentage('test');
    }

}
 