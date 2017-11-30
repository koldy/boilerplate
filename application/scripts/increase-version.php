<?php declare(strict_types=1);

use App\Cli\Exception as CliException;
use App\Config;
use Koldy\Log;

$config = Config::getConfig();
$oldVersion = Config::getVersion();

if ($oldVersion == null) {
	throw new CliException('Old portal version is not set');
}

$parts = explode('.', $oldVersion);
if (count($parts) != 3) {
	throw new CliException('Old portal version has invalid number of parts, required 3, got: ' . count($parts));
}

array_walk($parts, 'intval');
$parts[2]++;
$newVersion = implode('.', $parts);

$file = $config->getFullPath();
$content = file_get_contents($file);
$lines = explode("\n", $content);

$linesCount = count($lines);
for ($i = 0, $found = false; !$found && $i < $linesCount; $i++) {
	$line = $lines[$i];

	if (strpos($line, '\'version\'') !== false) {
		$found = true;
		$line = str_replace("'{$oldVersion}'", "'{$newVersion}'", $line);
		$lines[$i] = $line;
		Log::debug("Writing new version {$newVersion} to config file {$file}");
		file_put_contents($file, implode("\n", $lines));
	}
}

if (!$found) {
	throw new CliException('Could not find version in portal-config, version couldn\'t be updated');
}
