<?php
/*////////////////////////////////////////////////////////////////////////////////
	MorrowTwo - a PHP-Framework for efficient Web-Development
	Copyright (C) 2009  Christoph Erdmann, R.David Cummins

	This file is part of MorrowTwo <http://code.google.com/p/morrowtwo/>

	MorrowTwo is free software:  you can redistribute it and/or modify
	it under the terms of the GNU Lesser General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
////////////////////////////////////////////////////////////////////////////////*/

/*
CREATE TABLE IF NOT EXISTS `files` (
  `id` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` enum('file','dir') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `data` longblob NOT NULL,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Used for Db stream wrapper';
*/

namespace Morrow\Streams;

class Db {
	public static $config = array();
	
	protected $scheme;
	protected $db;

	protected $table;
	protected $id;
	protected $entry;
	protected $pos = 0;
	protected $mode;

	public function __construct($scheme = null, $table = null, \Morrow\Db $db = null) {
		if(!$scheme) return;
		
		self::$config[$scheme] = array(
			'db'	=> $db,
			'table'	=> $table,
		);
		stream_register_wrapper($scheme, __CLASS__);
	}




	public function dir_closedir() {
		// Any resources which were locked, or allocated, during opening and use of the directory stream should be released.
		return true;
	}

	public function dir_opendir($path, $options) {
		var_dump($path);
		die();
		return true;
	}

	public function dir_readdir($path, $options) {
		var_dump('dir_readdir');
		die();
	}

	public function dir_rewinddir($path, $options) {
		var_dump('dir_rewinddir');
		die();
	}

	public function mkdir($path, $mode, $options) {
		$parts = explode('://', $path, 2);

		$this->scheme	= $parts[0];
		$this->id		= rtrim($parts[1] ,'/') . '/';
		$this->db		= self::$config[$this->scheme]['db'];
		$this->table	= self::$config[$this->scheme]['table'];

		$this->entry = array(
			'id'	=> $this->id,
			'type'	=> 'dir',
			'data'	=> '',
			'ctime'	=> date('Y-m-d H:i:s', time()),
			'mtime'	=> date('Y-m-d H:i:s', time()),
		);

		//$this->db->insert($this->table, $this->entry);
		return false;
	}

	public function rename($path, $options) {
		var_dump('rename');
		die();
	}

	public function rmdir($path, $options) {
		var_dump('rmdir');
		die();
	}




	public function stream_cast() {
		// Should return the underlying stream resource used by the wrapper, or FALSE.
		return false;
	}

	public function stream_close() {
		var_dump('stream_close');
		// All resources that were locked, or allocated, by the wrapper should be released.
		return;
	}

	public function stream_eof() {
		var_dump('stream_eof');
		return ($this->pos === strlen($this->entry['data']) - 1);
	}

	public function stream_flush() {
		var_dump('stream_flush');
		// Should return TRUE if the cached data was successfully stored (or if there was no data to store), or FALSE if the data could not be stored.
		// because er have stored the data in stream_write() there is no possibility to return false.
		return true;
	}

	public function stream_lock($operation) {
		var_dump('stream_lock');
		return false;
	}

	public function stream_metadata($path, $option, $value) {
		var_dump('stream_metadata');
		return false;
	}

	public function stream_open($path, $mode, $options, &$opath) {
		var_dump('stream_open');
		
		$parts = explode('://', $path, 2);

		$this->scheme	= $parts[0];
		$this->id		= $parts[1];
		$this->db		= self::$config[$this->scheme]['db'];
		$this->table	= self::$config[$this->scheme]['table'];
		$this->mode		= $mode;
		$this->exists	= false;
		
		$this->entry = array(
			'id'	=> $this->id,
			'type'	=> 'file',
			'data'	=> '',
			'ctime'	=> time(),
			'mtime'	=> time(),
		);

		// handle the different modes
		$sql = $this->db->result("
			SELECT
				id,
				type,
				data,
				UNIX_TIMESTAMP(ctime) AS ctime,
				UNIX_TIMESTAMP(mtime) AS mtime
			FROM ". $this->table ."
			WHERE id = ?
			LIMIT 1
		", $this->id);

		// if file already exists: false
		if (in_array($this->mode, array('x', 'x+')) && $sql['NUM_ROWS'] === 0) return false;

		if (isset($sql['RESULT'][0])) {
			$this->entry = array_merge($this->entry, $sql['RESULT'][0]);
			$this->exists	= true;
		}

		// truncate file
		if (in_array($this->mode, array('w', 'x+'))) {
			$this->entry['data'] = '';
		}

		// set cursor position if different to 0
		if (in_array($this->mode, array('a', 'a+'))) {
			$this->pos = strlen($this->entry['data']) - 1;
		}

		return true;
	}

	public function stream_read($count) {
		var_dump('stream_read');
		$returner = substr($this->entry['data'], $this->pos, $count);
		// update position
		$this->pos = min($this->pos + $count, strlen($this->entry['data']));
		return $returner;
	}

	public function stream_seek($offset, $whence = SEEK_SET) {
		var_dump('stream_seek');
		if ($whence == SEEK_SET) $this->pos = $offset;
		elseif ($whence == SEEK_CUR) $this->pos += $offset;
		elseif ($whence == SEEK_END) $this->pos = strlen($this->entry['data']) - 1 + $offset;
		else { return false; }
		return true;
	}

	public function stream_set_option() {
		var_dump('stream_set_option');
		return false;
	}

	public function stream_stat() {
		var_dump('Exists: ');
		var_dump($this->exists);
		var_dump('stream_stat');
		// do not return anything if file not exists
		if (!$this->exists) return false;

		return array(
			'dev'		=> 0,
			'ino'		=> 0,
			'mode'		=> ($this->entry['type'] === 'dir' ? 16895 : 33279),
			'nlink'		=> 0,
			'uid'		=> 0,
			'gid'		=> 0,
			'rdev'		=> 0,
			'size'		=> strlen($this->entry['data']),
			'atime'		=> 0,
			'mtime'		=> $this->entry['mtime'],
			'ctime'		=> $this->entry['ctime'],
			'blksize'	=> 0,
			'blocks'	=> 0,
		);
	}

	public function stream_tell() {
		var_dump('stream_tell');
		return $this->pos;
	}

	public function stream_truncate($new_size) {
		var_dump('stream_truncate');
		$this->entry['data'] = '';
		$this->pos = 0;
		return true;
	}

	public function stream_write($data) {
		var_dump('stream_write');
		// try to add entry if it does not exist
		if (in_array($this->mode, array('w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'))) {
			
		}

		$this->entry['data']	= $data;
		$this->entry['ctime']	= date('Y-m-d H:i:s', $this->entry['ctime']);
		$this->entry['mtime']	= date('Y-m-d H:i:s', time());
		$this->db->replace($this->table, $this->entry);

		return strlen($data);
	}

	public function unlink($path) {
		var_dump('unlink');
		$this->stream_open($path, 'r', array(), $opath);
		$sql = $this->db->delete($this->table, 'WHERE id=?', false, $this->id);
		if ($sql['SUCCESS']) return true;
		return false;
	}

	public function url_stat($filename) {
		var_dump('url_stat');
		$this->stream_open($filename, 'r', array(), $opath);
		
		// do not return anything if file not exists
		if (!$this->exists) return false;

		return $this->stream_stat();

	}
}