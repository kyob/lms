<?php

/* BONUS module v0.1 alpha
 * 
 * Moduł ma za zadanie włączenie prędkości symetrycznej abonentowi, 
 * który spełni wymagane kryteria.
 * 
 * Używanie na własne ryzyko, gdyż moduł jest napisany pod konkretne założenia.
 * 
 * Kontakt: lukasz@alfa-system.pl
 * 

 */

$USERPANEL->AddModule(trans('Hotspot'),	// Display name
		    'hotspot', 		// Module name - must be the same as directory name
		    trans('Hotspot'), // Tip 
		    95,			// Priority
		    trans('Hotspot module')	// Description
		    );

?>