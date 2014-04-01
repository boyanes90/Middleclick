<?php

function mydoctype()
{
print '<!doctype html>';
}

function myheader($additionalHeaderContent = NULL)
{
print '<html>';
print '<head>';
print '<title>Middleclik company</title>';
print $additionalHeaderContent;
print '</head>';
}

function mybody($bodyContents = '', $asideContent = '')
{
print '<body>';
print '<div>';
print $bodyContents;
myaside($asideContent);
print '</div>';
print '</body>';
}

function getCsv($path)
{
		$dataFile = file($path);
		$datum = array();
		
		foreach($dataFile as $line)
		{
			$datum[] = str_getcsv($line);
		}
		
		return $datum;
}

function myaside($asideContent)
{
print '<div id="aside">';
print $asideContent;
print '</div>';
}

function myfooter()
{
print "<br /><em>Borja Yanes Garrido</em>";
print "<br /><em>A20313859</em>";
print '</html>';
}

?>