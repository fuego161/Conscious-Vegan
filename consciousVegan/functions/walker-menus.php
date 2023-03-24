<?php
class Walker_Menus extends Walker {
	// Tell Walker where to inherit it's parent and id values
	public $db_fields = [
		'parent' => 'menu_item_parent',
		'id'	 => 'db_id'
	];

	private $attributes;
	private $last_depth = 0;
	private $up_level;
	private $down_level;
	private $item_count;
	private $i = 1;

	public function __construct($menu_name, $class_prefix) {
		$this->menu_name = $menu_name;
		$this->class_prefix = $class_prefix;
		$this->item_count = wp_get_nav_menu_object($this->menu_name)->count;
	}

	public function hyphenate_string($string) {
		// Transform the sting to lowercase
		$lower_case_string = strtolower($string);

		// Replace spaces with hyphens
		$string_hyphenated = str_replace(' ', '-', $lower_case_string);

		return $string_hyphenated;
	}

	public function has_children($class_list) {
		// Find if the item has children
		return in_array('menu-item-has-children', $class_list);
	}

	public function set_attributes($item) {
		// Set the attributes for the list items
		if ($this->has_children($item->classes)) {
			// If the item is has children we want to give it an ID and make the URL 'javascript: undefined;'
			$id = $this->hyphenate_string($item->title);

			$this->attributes = [
				'id' => 'id="trigger-' . $id . '"',
				'url' => 'javascript: undefined;',
				'target' => ($item->target) === '_blank' ? $item->target : '_self',
			];
		}
		else {
			// If it's not then we don't need and ID and the URL can stay the same
			$this->attributes = [
				'id' => '',
				'url' => $item->url,
				'target' => ($item->target) === '_blank' ? $item->target : '_self',
			];
		}

		// Turn the classes into a string
		$classes = implode(' ', $item->classes);
		// Add the classes string to the attributes array
		$this->attributes['classes'] = $classes;
	}

	public function level_finder($item, $depth) {
		// If the item has the 'has-children' class we're going up a level
		$this->up_level = $this->has_children($item->classes) ? true : false;
		// If the items depth is less than the last we're going down a level
		$this->down_level = $depth < $this->last_depth ? true : false;
		// Set last depth to current depth
		$this->last_depth = $depth;
	}

	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		// Get the attributes for the items
		$this->set_attributes($item);
		// Find if we're moving up or down a level
		$this->level_finder($item, $depth);

		if ($this->down_level) {
			// If we're going down a level then we need to close the previous sub menu and item before moving on
			// Close the sub menu and li
			$output .= "</ul></li>\n";
		}

		// Set the main class to be added to the end of the given WP classes
		$main_class = ' ' . $this->class_prefix . '__item';

		if ($depth > 0) {
			// If we're above level 0, add a modifier to the main class
			$sub_class = ' ' . $this->class_prefix . '__item--sub';
			$main_class .= $sub_class;
		}

		// Add the main class to the given WP classes
		$this->attributes['classes'] .= $main_class;

		// Set the styles for the item
		$styles = array_key_exists('styles', $this->attributes) ? 'style="' . $this->attributes['styles'] . '"' : '';

		// Set the classes for the link
		$a_tag_classes = $this->class_prefix . '__link';
		if ($item->object_id === get_the_ID()) $a_tag_classes .= ' current';

		// Output the <li> opening and <a>
		$output .= sprintf( "\n<li %s class='%s' %s><a class='%s' href='%s' target='%s'>%s</a>",
			$this->attributes['id'],
			$this->attributes['classes'],
			$styles,
			$a_tag_classes,
			$this->attributes['url'],
			$this->attributes['target'],
			$item->title
		);

		if ($this->up_level) {
			$ul = '<ul class="' . $this->class_prefix . '__sub ' . $this->class_prefix . '__sub--' . ($depth + 1) . '">';
			// If we're going up a level open the sub menu
			$output .= $ul;
		}
		else {
			// Otherwise just output the </li> closing
			$output .= "</li>\n";
		}

		if ($this->item_count === $this->i) {
			// It's the last item so let's close everything up
			$output .= "</ul></li>\n";
		}

		// Keep the count going to check for last item
		$this->i++;
	}
}
