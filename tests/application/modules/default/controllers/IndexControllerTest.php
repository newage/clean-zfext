<?php
/**
 * Description of IndexControllerTest
 *
 * @author vadim
 */
class IndexControllerTest extends ControllerTestCase
{
    public function testCallWithoutActionShouldPullFromIndexAction()
    {
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
    }
}

