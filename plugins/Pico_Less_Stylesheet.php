<?php

/**
 * Checks if a less stylesheet exists and compiles it.
 *
 * @author Ruben Vincenten
 * @link http://rubenvincenten.nl
 * @license http://opensource.org/licenses/MIT
 * @version 1.0
 */
class Pico_Less_Stylesheet {

	protected $css_file;
	protected $less_file;

	//public function plugins_loaded()
	//public function request_url(&$url)
	public function request_url(&$url) {
		if (pathinfo($url, PATHINFO_EXTENSION) == 'css') {
			$file = preg_replace('@\.css$@', '.less', $url);
			if (is_file($file)) {
				$this -> css_file = CONTENT_DIR . $url;
				$this -> less_file = $file;
			}
		}
	}

	//public function before_load_content(&$file)
	//public function after_load_content(&$file, &$content)
	//public function before_404_load_content(&$file)
	//public function after_404_load_content(&$file, &$content)
	//public function config_loaded(&$settings)
	//public function file_meta(&$meta)
	//public function content_parsed(&$content)
	//public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	//public function before_twig_register()
	//public function before_render(&$twig_vars, &$twig)
	public function before_render(&$twig_vars, &$twig) {
		if ($this -> less_file) {
			echo $this -> autoCompileLess($this -> less_file, $this -> css_file);
			header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
			header("Content-Type: text/css");
			exit ;
		}
	}

	//public function after_render(&$output)

	public function autoCompileLess($inputFile, $outputFile) {
		// load the cache
		$cacheFile = CACHE_DIR . md5($inputFile);

		if (file_exists($cacheFile)) {
			$cache = unserialize(file_get_contents($cacheFile));
		} else {
			$cache = $inputFile;
		}
		try {
			// :)
			require MODULES_DIR . 'lessphp/lessc.inc.php';
			$less = new lessc;
			$less->setPreserveComments(true);

			$newCache = $less -> cachedCompile($cache);

			if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
				file_put_contents($cacheFile, serialize($newCache));
				if (is_writable($outputFile)) {
					file_put_contents($outputFile, $newCache['compiled']);
				}
			}
		} catch(Exception $e) {
			die($e);
		}

		return $newCache['compiled'];
	}
}