<?php
namespace Composer\Autoload;
if (!defined('ABSPATH')) exit;
class ClassLoader
{
 private $vendorDir;
 // PSR-4
 private $prefixLengthsPsr4 = array();
 private $prefixDirsPsr4 = array();
 private $fallbackDirsPsr4 = array();
 // PSR-0
 private $prefixesPsr0 = array();
 private $fallbackDirsPsr0 = array();
 private $useIncludePath = false;
 private $classMap = array();
 private $classMapAuthoritative = false;
 private $missingClasses = array();
 private $apcuPrefix;
 private static $registeredLoaders = array();
 public function __construct($vendorDir = null)
 {
 $this->vendorDir = $vendorDir;
 }
 public function getPrefixes()
 {
 if (!empty($this->prefixesPsr0)) {
 return call_user_func_array('array_merge', array_values($this->prefixesPsr0));
 }
 return array();
 }
 public function getPrefixesPsr4()
 {
 return $this->prefixDirsPsr4;
 }
 public function getFallbackDirs()
 {
 return $this->fallbackDirsPsr0;
 }
 public function getFallbackDirsPsr4()
 {
 return $this->fallbackDirsPsr4;
 }
 public function getClassMap()
 {
 return $this->classMap;
 }
 public function addClassMap(array $classMap)
 {
 if ($this->classMap) {
 $this->classMap = array_merge($this->classMap, $classMap);
 } else {
 $this->classMap = $classMap;
 }
 }
 public function add($prefix, $paths, $prepend = false)
 {
 if (!$prefix) {
 if ($prepend) {
 $this->fallbackDirsPsr0 = array_merge(
 (array) $paths,
 $this->fallbackDirsPsr0
 );
 } else {
 $this->fallbackDirsPsr0 = array_merge(
 $this->fallbackDirsPsr0,
 (array) $paths
 );
 }
 return;
 }
 $first = $prefix[0];
 if (!isset($this->prefixesPsr0[$first][$prefix])) {
 $this->prefixesPsr0[$first][$prefix] = (array) $paths;
 return;
 }
 if ($prepend) {
 $this->prefixesPsr0[$first][$prefix] = array_merge(
 (array) $paths,
 $this->prefixesPsr0[$first][$prefix]
 );
 } else {
 $this->prefixesPsr0[$first][$prefix] = array_merge(
 $this->prefixesPsr0[$first][$prefix],
 (array) $paths
 );
 }
 }
 public function addPsr4($prefix, $paths, $prepend = false)
 {
 if (!$prefix) {
 // Register directories for the root namespace.
 if ($prepend) {
 $this->fallbackDirsPsr4 = array_merge(
 (array) $paths,
 $this->fallbackDirsPsr4
 );
 } else {
 $this->fallbackDirsPsr4 = array_merge(
 $this->fallbackDirsPsr4,
 (array) $paths
 );
 }
 } elseif (!isset($this->prefixDirsPsr4[$prefix])) {
 // Register directories for a new namespace.
 $length = strlen($prefix);
 if ('\\' !== $prefix[$length - 1]) {
 throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
 }
 $this->prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
 $this->prefixDirsPsr4[$prefix] = (array) $paths;
 } elseif ($prepend) {
 // Prepend directories for an already registered namespace.
 $this->prefixDirsPsr4[$prefix] = array_merge(
 (array) $paths,
 $this->prefixDirsPsr4[$prefix]
 );
 } else {
 // Append directories for an already registered namespace.
 $this->prefixDirsPsr4[$prefix] = array_merge(
 $this->prefixDirsPsr4[$prefix],
 (array) $paths
 );
 }
 }
 public function set($prefix, $paths)
 {
 if (!$prefix) {
 $this->fallbackDirsPsr0 = (array) $paths;
 } else {
 $this->prefixesPsr0[$prefix[0]][$prefix] = (array) $paths;
 }
 }
 public function setPsr4($prefix, $paths)
 {
 if (!$prefix) {
 $this->fallbackDirsPsr4 = (array) $paths;
 } else {
 $length = strlen($prefix);
 if ('\\' !== $prefix[$length - 1]) {
 throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
 }
 $this->prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
 $this->prefixDirsPsr4[$prefix] = (array) $paths;
 }
 }
 public function setUseIncludePath($useIncludePath)
 {
 $this->useIncludePath = $useIncludePath;
 }
 public function getUseIncludePath()
 {
 return $this->useIncludePath;
 }
 public function setClassMapAuthoritative($classMapAuthoritative)
 {
 $this->classMapAuthoritative = $classMapAuthoritative;
 }
 public function isClassMapAuthoritative()
 {
 return $this->classMapAuthoritative;
 }
 public function setApcuPrefix($apcuPrefix)
 {
 $this->apcuPrefix = function_exists('apcu_fetch') && filter_var(ini_get('apc.enabled'), FILTER_VALIDATE_BOOLEAN) ? $apcuPrefix : null;
 }
 public function getApcuPrefix()
 {
 return $this->apcuPrefix;
 }
 public function register($prepend = false)
 {
 spl_autoload_register(array($this, 'loadClass'), true, $prepend);
 if (null === $this->vendorDir) {
 return;
 }
 if ($prepend) {
 self::$registeredLoaders = array($this->vendorDir => $this) + self::$registeredLoaders;
 } else {
 unset(self::$registeredLoaders[$this->vendorDir]);
 self::$registeredLoaders[$this->vendorDir] = $this;
 }
 }
 public function unregister()
 {
 spl_autoload_unregister(array($this, 'loadClass'));
 if (null !== $this->vendorDir) {
 unset(self::$registeredLoaders[$this->vendorDir]);
 }
 }
 public function loadClass($class)
 {
 if ($file = $this->findFile($class)) {
 includeFile($file);
 return true;
 }
 return null;
 }
 public function findFile($class)
 {
 // class map lookup
 if (isset($this->classMap[$class])) {
 return $this->classMap[$class];
 }
 if ($this->classMapAuthoritative || isset($this->missingClasses[$class])) {
 return false;
 }
 if (null !== $this->apcuPrefix) {
 $file = apcu_fetch($this->apcuPrefix.$class, $hit);
 if ($hit) {
 return $file;
 }
 }
 $file = $this->findFileWithExtension($class, '.php');
 // Search for Hack files if we are running on HHVM
 if (false === $file && defined('HHVM_VERSION')) {
 $file = $this->findFileWithExtension($class, '.hh');
 }
 if (null !== $this->apcuPrefix) {
 apcu_add($this->apcuPrefix.$class, $file);
 }
 if (false === $file) {
 // Remember that this class does not exist.
 $this->missingClasses[$class] = true;
 }
 return $file;
 }
 public static function getRegisteredLoaders()
 {
 return self::$registeredLoaders;
 }
 private function findFileWithExtension($class, $ext)
 {
 // PSR-4 lookup
 $logicalPathPsr4 = strtr($class, '\\', DIRECTORY_SEPARATOR) . $ext;
 $first = $class[0];
 if (isset($this->prefixLengthsPsr4[$first])) {
 $subPath = $class;
 while (false !== $lastPos = strrpos($subPath, '\\')) {
 $subPath = substr($subPath, 0, $lastPos);
 $search = $subPath . '\\';
 if (isset($this->prefixDirsPsr4[$search])) {
 $pathEnd = DIRECTORY_SEPARATOR . substr($logicalPathPsr4, $lastPos + 1);
 foreach ($this->prefixDirsPsr4[$search] as $dir) {
 if (file_exists($file = $dir . $pathEnd)) {
 return $file;
 }
 }
 }
 }
 }
 // PSR-4 fallback dirs
 foreach ($this->fallbackDirsPsr4 as $dir) {
 if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr4)) {
 return $file;
 }
 }
 // PSR-0 lookup
 if (false !== $pos = strrpos($class, '\\')) {
 // namespaced class name
 $logicalPathPsr0 = substr($logicalPathPsr4, 0, $pos + 1)
 . strtr(substr($logicalPathPsr4, $pos + 1), '_', DIRECTORY_SEPARATOR);
 } else {
 // PEAR-like class name
 $logicalPathPsr0 = strtr($class, '_', DIRECTORY_SEPARATOR) . $ext;
 }
 if (isset($this->prefixesPsr0[$first])) {
 foreach ($this->prefixesPsr0[$first] as $prefix => $dirs) {
 if (0 === strpos($class, $prefix)) {
 foreach ($dirs as $dir) {
 if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr0)) {
 return $file;
 }
 }
 }
 }
 }
 // PSR-0 fallback dirs
 foreach ($this->fallbackDirsPsr0 as $dir) {
 if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr0)) {
 return $file;
 }
 }
 // PSR-0 include paths.
 if ($this->useIncludePath && $file = stream_resolve_include_path($logicalPathPsr0)) {
 return $file;
 }
 return false;
 }
}
function includeFile($file)
{
 include $file;
}