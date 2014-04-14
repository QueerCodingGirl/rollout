<?php

class RolloutDeactivateTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers DarkGigaByte\Rollout\RolloutAbstract::deactivate
     */
    public function testDeactivate()
    {
        $feature = $this->getMockBuilder('\DarkGigaByte\Rollout\Feature\CoreFeature')
            ->disableOriginalConstructor()
            ->setMethods(array('clearConfig'))
            ->getMock();

        $feature->expects($this->once())
            ->method('clearConfig')
            ->will($this->returnValue($feature));

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

        $rollout->deactivate('test');
    }

}
 