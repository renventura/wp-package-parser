<?php
namespace RenVentura\WPPackageParser\Parsers;

/**
 * Class for parsing a WordPress theme.
 */
class ThemeParser extends Parser {

	/**
	 * Header map.
	 *
	 * @var array
	 */
	protected $headerMap = array(
		'name'        => 'Theme Name',
		'theme_uri'   => 'Theme URI',
		'description' => 'Description',
		'author'      => 'Author',
		'author_uri'  => 'Author URI',
		'version'     => 'Version',
		'template'    => 'Template',
		'status'      => 'Status',
		'tags'        => 'Tags',
		'text_domain' => 'Text Domain',
		'domain_path' => 'Domain Path',
	);

	/**
	 * Parse style.css file.
	 *
	 * @param string $fileContents Contents of style.css file.
	 *
	 * @return array|null
	 */
	public function parseStyle( string $fileContents ) : array|null {

        $headers = $this->parseHeaders( $fileContents );
		$headers['tags'] = array_filter( array_map( 'trim', explode( ',', strip_tags( $headers['tags'] ) ) ) );

		// If it doesn't have a name, it's probably not a valid theme.
		if ( empty( $headers['name'] ) ) {
			return null;
		}

		return $headers;
	}
}
