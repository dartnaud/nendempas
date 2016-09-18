<?php

namespace NNP\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NNPUserBundle extends Bundle
{
	public function getParent(){
		return 'FOSUserBundle';
	}
}
