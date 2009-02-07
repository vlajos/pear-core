--TEST--
install command, package.xml 1.0 package depends on pecl
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
error_reporting(1803);
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';

$reg = &$config->getRegistry();
$chan = $reg->getChannel('pecl.php.net');
$chan->setBaseURL('REST1.0', 'http://pecl.php.net/rest/');
$reg->updateChannel($chan);

$reg = &$config->getRegistry();
$chan = $reg->getChannel('pear.php.net');
$chan->setBaseURL('REST1.0', 'http://pear.php.net/rest/');
$reg->updateChannel($chan);

$pathtopackagexml = dirname(__FILE__)  . DIRECTORY_SEPARATOR . 'packages'. DIRECTORY_SEPARATOR . 'dependsonpecl.xml';
PEAR::pushErrorHandling(PEAR_ERROR_RETURN);

$pearweb->addRESTConfig("http://pear.php.net/rest/r/radius/allreleases.xml", false, false);

PEAR::popErrorHandling();

$pearweb->addRESTConfig("http://pecl.php.net/rest/r/radius/allreleases.xml", '<?xml version="1.0" encoding="UTF-8" ?>
<a xmlns="http://pear.php.net/dtd/rest.allreleases"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xlink="http://www.w3.org/1999/xlink"     xsi:schemaLocation="http://pear.php.net/dtd/rest.allreleases
    http://pear.php.net/dtd/rest.allreleases.xsd">
 <p>radius</p>
 <c>pecl.php.net</c>
 <r><v>1.3.0</v><s>stable</s></r>
 <r><v>1.2.5</v><s>stable</s></r>
 <r><v>1.2.4</v><s>stable</s></r>
 <r><v>1.2.3</v><s>stable</s></r>
 <r><v>1.2.2</v><s>stable</s></r>
 <r><v>1.2.1</v><s>stable</s></r>
 <r><v>1.2</v><s>stable</s></r>
 <r><v>1.1</v><s>stable</s></r>
</a>', 'text/xml');

$pearweb->addRESTConfig("http://pecl.php.net/rest/p/radius/info.xml", '<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xlink="http://www.w3.org/1999/xlink"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>radius</n>
 <c>pecl.php.net</c>
 <ca xlink:href="/rest/c/Authentication">Authentication</ca>
 <l>BSD</l>
 <s>extension package source package</s>
 <d>extension source</d>
 <r xlink:href="/rest/r/radius"/>
</p>', 'text/xml');

$pearweb->addRESTConfig("http://pecl.php.net/rest/r/radius/1.3.0.xml", '<?xml version="1.0" encoding="UTF-8" ?>
<r xmlns="http://pear.php.net/dtd/rest.release"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.release
    http://pear.php.net/dtd/rest.release.xsd">
 <p xlink:href="/rest/p/radius">radius</p>
 <c>pecl.php.net</c>
 <v>1.3.0</v>
 <st>stable</st>
 <l>BSD</l>
 <m>cellog</m>
 <s>extension package source package</s>
 <d>extension source</d>
 <da>2007-03-18 17:02:49</da>
 <n>stuff</n>
 <f>29750</f>
 <g>http://pecl.php.net/get/peclpackage-1.3.0</g>
 <x xlink:href="package.1.3.0.xml"/>
</r>', 'text/xml');

$pearweb->addRESTConfig("http://pecl.php.net/rest/r/radius/deps.1.3.0.txt", 'a:1:{s:8:"required";a:2:{s:3:"php";a:1:{s:3:"min";s:5:"4.2.0";}s:13:"pearinstaller";a:1:{s:3:"min";s:7:"1.4.0b1";}}}', 'text/xml');

/*

$pearweb->addXmlrpcConfig("pecl.php.net", "package.getDepDownloadURL", array (
  0 => '2.0',
  1 =>
  array (
    'channel' => 'pecl.php.net',
    'name' => 'radius',
  ),
  2 =>
  array (
    'channel' => 'pear.php.net',
    'package' => 'PEAR',
    'version' => '1.4.0a1',
  ),
  3 => 'stable',
),     array('version' => '1.5.2',
             'info' => '<?xml version="1.0"?>
<package version="2.0" xmlns="http://pear.php.net/dtd/package-2.0" xmlns:tasks="http://pear.php.net/dtd/tasks-1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://pear.php.net/dtd/tasks-1.0
http://pear.php.net/dtd/tasks-1.0.xsd
http://pear.php.net/dtd/package-2.0
http://pear.php.net/dtd/package-2.0.xsd">
 <name>peclpkg</name>
 <channel>pecl.php.net</channel>
 <summary>extension package source package</summary>
 <description>extension source
 </description>
 <lead>
  <name>Greg Beaver</name>
  <user>cellog</user>
  <email>cellog@php.net</email>
  <active>yes</active>
 </lead>
 <date>2004-09-30</date>
 <version>
  <release>1.3.0</release>
  <api>1.3.0</api>
 </version>
 <stability>
  <release>stable</release>
  <api>stable</api>
 </stability>
 <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
 <notes>stuff
 </notes>
 <contents>
  <dir name="/">
   <file name="foo.php" role="src"/>
  </dir>
 </contents>
 <dependencies>
  <required>
   <php>
    <min>4.2.0</min>
   </php>
   <pearinstaller>
    <min>1.4.0dev13</min>
   </pearinstaller>
  </required>
 </dependencies>
 <providesextension>extpkg</providesextension>
 <extsrcrelease/>
</package>',
             'url' => 'http://pecl.php.net/get/peclpackage-1.3.0')
);
*/

$res = $command->run('install', array(), array($pathtopackagexml));
$phpunit->assertErrors(array(
    array(
        'package' => 'PEAR_Error',
        'message' => 'install failed'
    ),
    array(
        'package' => 'PEAR_PackageFile_v2',
        'message' => 'Channel validator warning: field "providesextension" - package name "peclpkg" is different from extension name "extpkg"'
    ),
), 'after install');

$dl = &$command->getDownloader(1, array());

$phpunit->assertEquals(array (
  array (
    0 => 3,
    1 => 'Notice: package "pear/PEAR" required dependency "pecl/radius" will not be automatically downloaded',
  ),
  array (
    0 => 1,
    1 => 'Did not download dependencies: pecl/radius, use --alldeps or --onlyreqdeps to download automatically',
  ),
  array (
    0 => 0,
    1 => 'pear/PEAR requires package "pear/radius"',
  ),
  array (
    'info' =>
    array (
      'data' =>
      array (
        0 =>
        array (
          0 => 'No valid packages found',
        ),
      ),
      'headline' => 'Install Errors',
    ),
    'cmd' => 'no command',
  ),
), $fakelog->getLog(), 'log messages');

$phpunit->assertEquals( array (
  0 =>
  array (
    0 => 'http://pear.php.net/rest/r/radius/allreleases.xml',
    1 => '404',
  ),
  1 =>
  array (
    0 => 'http://pecl.php.net/rest/r/radius/allreleases.xml',
    1 => '200',
  ),
  2 =>
  array (
    0 => 'http://pecl.php.net/rest/p/radius/info.xml',
    1 => '200',
  ),
  3 =>
  array (
    0 => 'http://pecl.php.net/rest/r/radius/1.3.0.xml',
    1 => '200',
  ),
  4 =>
  array (
    0 => 'http://pecl.php.net/rest/r/radius/deps.1.3.0.txt',
    1 => '200',
  ),
 )
, $pearweb->getRESTCalls(), 'rest calls');

echo 'tests done';
?>
--CLEAN--
<?php
require_once dirname(dirname(__FILE__)) . '/teardown.php.inc';
?>
--EXPECT--
tests done
