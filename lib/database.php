<?php
	class Database {
		private static $db_connection = null;

		private function __construct() {}

		private static function getConnection() {
			if(self::$db_connection === null) {
				self::$db_connection = new Mongo("mongodb://master:drop55@ds029107.mongolab.com:29107/albums");
			}

			return self::$db_connection;
		}

		public static function getAlbums($type = 'wishlist', $order = 'year') {
			$albums = array();
			$conn = self::getConnection();

			$db = $conn->albums;
			$collection = $db->album;
			$album_list = $collection->find(array('type' => $type));
			// Sort by parameter ascendent
			$album_list->sort(array($order => 1, 'year' => 1));

			foreach($album_list as $album) {
				array_push($albums, $album);
			}

			return $albums;
		}
	}

?>
