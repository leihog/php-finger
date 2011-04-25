#!/usr/bin/env php
<?php

class Fingerd
{
	public function __construct()
	{
		$this->main();
	}

	protected function readInput( $stdin )
	{
		$canRead = stream_select($read = array($stdin), $write = null, $except = null, 0);
		if (is_int($canRead) && $canRead > 0)
		{
			return trim(fgets($stdin, 512));
        }

        return false;
	}
	
	protected function getPlan( $user )
	{
		$plan = '';
		$filename = '/home/' . $user . '/.plan';
		if ( is_readable($filename) )
		{
			$plan = file_get_contents($filename);
		}

		if ( !empty($plan) )
		{
			$plan = "You fingered the user '{$user}'\nPlan:\n" . $plan;
		}
		
		return $plan;
	}

	protected function isValid( $input )
	{
		if ( preg_match( '/^[a-z]{1}[a-z0-9-_]{0,31}$/i', $input ) )
		{
			return true;
		}
		
		return false;
	}
	
	protected function main()
	{
		$input = $this->readInput(STDIN);
		if ( !empty($input) && $this->isValid($input) )
		{
			echo $this->getPlan( strtolower($input) );
		}
	}
}
new Fingerd();