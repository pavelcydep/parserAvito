<?php
class ParserCurl {

	public $dirCacheFile = __DIR__ . "/cache_files/";

	/* ДЛЯ ОТПРАВКИ ЗАПРОСОВ */
	public function parserQuery($url) {

		if($this->cacheCheckStatus($url)) {
			return $this->cacheGetData($url);
		}

		$headers = array(
			'cache-control: max-age=0',
			'upgrade-insecure-requests: 1',
			'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
			'sec-fetch-user: ?1',
			'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
			
		);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$resultQuery = curl_exec($ch);

		if($resultQuery == false) {
			if ($errno = curl_errno($ch)) {
				$message = curl_strerror($errno);
				$dataReturn = "cURL error ({$errno}):\n {$message}";
			}
			else {
				$dataReturn = $html;
			}
		}
		else {
			$dataReturn = $resultQuery;
		}

		curl_close($ch);

		$this->cacheSetData($url, $dataReturn); 

		return $dataReturn;
	}
	/* ========================= */
	

	/* ПРОВЕРЯЕМ АКТУАЛЬНОСТЬ КЭША */
	public function cacheCheckStatus($urlData) {

		$urlCacheFile = md5($urlData);
		/* путь до файла с кэшем */
		$urlFileCache = $this->dirCacheFile . $urlCacheFile . ".txt";

		/* проверяем существование файла кэша */
		if(file_exists($urlFileCache)) {

			$dataUpdateFile = filemtime($urlFileCache);

			/* если кэш просрочился */
			if((time() - $dataUpdateFile) > 86400) {
				return false;
			}
			else {
				return true;
			}
		}
		else {
			return false;
		}
	}
	/* ======================= */



	/* ЗАПИСЫВАЕМ ДАННЫЕ В CACHE */
	public function cacheSetData($urlData, $dataSave) {
		$urlCacheFile = md5($urlData);
		/* путь до файла с кэшем */
		$urlFileCache = $this->dirCacheFile . $urlCacheFile . ".txt";

		$fh = fopen($urlFileCache, 'w');
		fwrite($fh, $dataSave);
		fclose($fh);

		return $dataSave;
	}
	/* ======================= */


	/* ПОЛУЧАЕМ ДАННЫЕ ИЗ CACHE */
	public function cacheGetData($urlData) {
		
		$urlCacheFile = md5($urlData);
		/* путь до файла с кэшем */
		$urlFileCache = $this->dirCacheFile . $urlCacheFile . ".txt";

		/* проверяем существование файла кэша и его актуальность */
		if($this->cacheCheckStatus($urlData)) {
			$dataCachFile = file_get_contents($urlFileCache);
			return $dataCachFile;
		}
		else {
			return false;
		}
		
	}
	/* ======================= */


}
?>