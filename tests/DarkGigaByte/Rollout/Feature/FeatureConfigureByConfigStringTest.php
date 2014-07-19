<?php

/**
 * Class FeatureConfigureByConfigStringTest
 */
class FeatureConfigureByConfigStringTest extends \PHPUnit_Framework_TestCase {


    /**
     * @dataProvider configureByConfigStringProvider
     * @covers DarkGigaByte\Rollout\Feature\FeatureAbstract::configureByConfigString()
     */
    public function testConfigureByConfigStringTest(
        $configString,
        $percentage,
        array $users,
        array $roles,
        array $groups,
        $returnValue
    ) {
        $feature = $this->getMockBuilder('\DarkGigaByte\Rollout\Feature\CoreFeature')
            ->disableOriginalConstructor()
            ->setMethods(array('setPercentage', 'setUsers', 'setRoles', 'setGroups'))
            ->getMock();

        if (true === $returnValue) {
            $feature->expects($this->once())
               ->method('setPercentage')
               ->with($this->equalTo($percentage))
               ->will($this->returnValue($feature));

            $feature->expects($this->once())
               ->method('setUsers')
               ->with($this->equalTo($users))
               ->will($this->returnValue($feature));

            $feature->expects($this->once())
               ->method('setRoles')
               ->with($this->equalTo($roles))
               ->will($this->returnValue($feature));

            $feature->expects($this->once())
               ->method('setGroups')
               ->with($this->equalTo($groups))
               ->will($this->returnValue($feature));
        }

        $this->assertEquals($returnValue, $feature->configureByConfigString($configString));
    }

    /**
     * @return array
     */
    public function configureByConfigStringProvider()
    {
        return array(
            array(
                '100|1,2,3,4|ROLE_ADMIN,ROLE_PREMIUM|caretaker,supporter,staff',
                100,
                array(1,2,3,4),
                array('ROLE_ADMIN','ROLE_PREMIUM'),
                array('caretaker', 'supporter', 'staff'),
                true
            ),
            array(
                '49|1,2,3,4|ROLE_ADMIN,ROLE_PREMIUM|caretaker,supporter,staff',
                49,
                array(1,2,3,4),
                array('ROLE_ADMIN','ROLE_PREMIUM'),
                array('caretaker', 'supporter', 'staff'),
                true
            ),
            array(
                '100||ROLE_ADMIN,ROLE_PREMIUM|caretaker,supporter,staff',
                100,
                array(),
                array('ROLE_ADMIN','ROLE_PREMIUM'),
                array('caretaker', 'supporter', 'staff'),
                true
            ),
            array(
                '100|1,2,3,4||caretaker,supporter,staff',
                100,
                array(1,2,3,4),
                array(),
                array('caretaker', 'supporter', 'staff'),
                true
            ),
            array(
                '100|1,2,3,4|ROLE_ADMIN,ROLE_PREMIUM|',
                100,
                array(1,2,3,4),
                array('ROLE_ADMIN','ROLE_PREMIUM'),
                array(),
                true
            ),
            array(
                '|||',
                0,
                array(),
                array(),
                array(),
                true
            ),
            array(
                'wtfIsThis?ThisIsNotAConfigString!',
                0,
                array(),
                array(),
                array(),
                false
            ),
            array(
                '||',
                0,
                array(),
                array(),
                array(),
                false
            )
        );
    }
}
 