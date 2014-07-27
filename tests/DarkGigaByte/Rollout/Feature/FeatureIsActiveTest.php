<?php

/**
 * Class FeatureIsActiveTest
 */
class FeatureIsActiveTest extends \PHPUnit_Framework_TestCase {


    /**
     * @dataProvider isActiveProvider
     * @covers DarkGigaByte\Rollout\Feature\FeatureAbstract::isActive()
     */
    public function testIsActiveTest(
        $userId,
        $percentage,
        $isUserInPercentage,
        $isUserInActiveUsers,
        $isUserInActiveRole,
        $isUserInActiveGroup,
        $returnValue
    ) {

        $rollout = $this->getMockBuilder('\DarkGigaByte\Rollout\Rollout')
            ->disableOriginalConstructor()
            ->setMethods(array('userHasRole', 'userHasGroup'))
            ->getMock();

        $user = $this->getMock(
            'DarkGigaByte\Rollout\Interfaces\DeterminableUserInterface',
            array('getId', 'getRoles', 'getGroups')
        );
        $user->expects($this->any())->method('getId')->willReturn($userId);


        $feature = $this->getMockBuilder('\DarkGigaByte\Rollout\Feature\CoreFeature')
            ->disableOriginalConstructor()
            ->setMethods(
                array(
                    'getPercentage',
                    'isUserInPercentage',
                    'isUserInActiveUsers',
                    'isUserInActiveRole',
                    'isUserInActiveGroup'
                )
            )
            ->getMock();

        $feature->expects($this->once())
            ->method('getPercentage')
            ->willReturn($percentage);
        $feature->expects($this->any())
            ->method('isUserInPercentage')
            ->with($userId)
            ->willReturn($isUserInPercentage);
        $feature->expects($this->any())
            ->method('isUserInActiveUsers')
            ->with($userId)
            ->willReturn($isUserInActiveUsers);
        $feature->expects($this->any())
            ->method('isUserInActiveRole')
            ->with($user, $rollout)
            ->willReturn($isUserInActiveRole);
        $feature->expects($this->any())
            ->method('isUserInActiveGroup')
            ->with($user, $rollout)
            ->willReturn($isUserInActiveGroup);

        $userParam = $user;
        if(null === $userId) {
            $userParam = null;
        }

        $this->assertEquals($returnValue, $feature->isActive($rollout, $userParam));
    }

    /**
     * @return array
     */
    public function isActiveProvider() {
        return array(
            array(1, 0, false, false, false, false, false),
            array(1, 100, true, false, false, false, true),
            array(1, 50, true, false, false, false, true),
            array(1, 0, false, true, false, false, true),
            array(1, 0, false, false, true, false, true),
            array(1, 0, false, false, false, true, true),
            array(null, 0, false, false, false, false, false),
        );
    }
}
 