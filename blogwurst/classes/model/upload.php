
<?php
/**
 * Part of Blogwurst
 *
 * @packacge  Blogwurst
 * @version   1.0
 * @license   MIT
 */
/**
 * Upload model
 *
 * Handles the upload data.
 */
class Model_Upload extends Orm\Model
{

	/**
	 * Img dir
	 *
	 * @const  string  Dirname of the image store
	 */
	const IMG_DIR = 'img';

	/**
	 * Files dir
	 *
	 * @const  string  Dirname of the files store
	 */
	const FILES_DIR = 'files';

	/**
	 * Table name
	 *
	 * @var  string  The db table
	 */
	protected static $_table_name = 'uploads';

	/**
	 * Proeprties
	 *
	 * @var  array  The db table cols
	 */
	protected static $_properties = array(
		'id'       => array('data_type' => 'int'),
		'filename' => array('data_type' => 'varchar'),
		'folder'   => array('data_type' => 'varchar'),
	);

	/**
	 * Observers
	 *
	 * @var  array  Needed observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_Typing' => array(
			'events' => array('before_save', 'after_save', 'after_load'),
		),
	);

	/**
	 * Image mime types
	 *
	 * @var  array  Files with mimetypes listed in this array will be treated as images
	 */
	protected static $_img_mt = array('image/png', 'image/jpeg', 'image/gif');

	/**
	 * Path
	 *
	 * Returns the path to the store or to the file, if a Model_Upload is given.
	 *
	 * @param   string|Model_Upload  Storename or instance of Model_Upload
	 * @return  string
	 */
	protected static function _path($x)
	{
		$p = DOCROOT.'assets'.DS;

		return ($x instanceof static) ? $p.$x->folder.DS.$x->filename : $p.$x;
	}

	/**
	 * Save uploads
	 *
	 *
	 */
	public static function save_uploads()
	{
		Upload::process(array(
			'randomize'   => false,
			'auto_rename' => true,
			'overwrite'   => false,
		));

		if ( ! Upload::is_valid())
		{
			return false;
		}

		foreach(Upload::get_files() as $f)
		{
			$d = (in_array($f['mimetype'], static::$_img_mt)) ? static::IMG_DIR : static::FILES_DIR;

			try
			{
				Upload::save(static::_path($d), $f['key']);
			}
			catch (Exception $e)
			{
				continue;
			}

			if ($filename = Arr::get(Upload::get_files($f['key']), 'saved_as', false))
			{
				static::forge(array('filename' => $filename, 'folder' => $d))->save();
			}
		}

		return true;
	}

	/**
	 * Path
	 *
	 * Returns the path to file
	 *
	 * @param   void
	 * @return  string  Path to the file
	 */
	public function path()
	{
		return static::_path($this);
	}

	/**
	 * Delete
	 *
	 * Deletes the file and the database entry.
	 *
	 * @param   mixed         See Orm\Model::delete()
	 * @param   bool          See Orm\Model::delete()
	 * @return  Model_Upload  See Orm\Model::delete()
	 */
	public function delete($cascade = null, $trans = false)
	{
		try
		{
			File::delete($this->path());
		}
		catch (Exception $e) {}

		return parent::delete();
	}
}
