<?php

namespace Morrow;

class DefaultController extends Factory {
	public function setup() {
		$this->view->setHandler('serpent');

		/*
		// add CSP security rules
		$this->security->setCsp(array(
			'default-src'	=> "'self'",
			//'script-src'	=> "'self'",
			//'img-src'		=> "'self'",
			'style-src'		=> "'self' http://fonts.googleapis.com",
			//'media-src'	=> "'self'",
			//'object-src'	=> "'self'",
			//'frame-src'	=> "'self'",
			'font-src'		=> "'self' http://themes.googleusercontent.com",
		));

		// Do not allow to show this site in a frameset (prevents clickjacking)
		$this->security->setFrameOptions('DENY');
		*/
	}
}
