<?php

use Fewbricks\ACF\Fields\Select;
use \Fewbricks\ACF\Fields\Text;

return [

    /**
     *
     */
    'backend_name' => (new Text('Backend name', 'backend_name', '2001022211a'))
        ->set_instructions('Anything you enter here will only be visible in the backend and will be added to the name of the block you are currently editing. So if you enter "Two columns with teasers" in this field and the field is under "Content block settings", after you have saved and reloaded this page, the label for the field group will be something like "Two columns with teasers - Content block".<br>'),

    /**
     *
     */
    'colors_1' => (new Select('Color', 'color', '2001291758a'))
        ->set_choices([
            'inherit' => 'None (transparent)',
            'red' => 'Red',
            'blue' => 'Blue'
        ])
        ->set_allow_null(false),

    /**
     *
     */
    'column_width_1' => (new Select('Column width', 'column_width', '2001022141a'))
        ->set_choices([
            '12' => '12/12',
            '11' => '11/12',
            '10' => '10/12',
            '9' => '9/12',
            '8' => '8/12',
            '7' => '7/12',
            '6' => '6/12',
            '5' => '5/12',
            '4' => '4/12',
            '3' => '3/12',
        ])
        ->set_default_value('12')
        ->set_allow_null(false)
        ->set_instructions('Column widths are based on a 12-column system. Selecting for example 12/12 will result in a column spanning the entire width of the row. 6/12 would have the column span 50% of the row. If you place two or more columns with a combined column width of more than 12 (for example a 9/12 and one 4/12 or two 5/12 and one 7/12), the system will calculate the row breaks for you. The first example would result in one row with a 9/12 column and another row with 4/12 whereas the second example would render one row with two 5/12 and one row with 7/12.<br><br>Note that these columns only are used on screens above a certain screen size. On smaller screens (basically phones held horizontally and smaller) we will stack the columns on top of each other regardless of the column setting.</span><br><br>We are using a grid system called <a href="https://v4-alpha.getbootstrap.com/layout/grid/" target="_blank">Bootstrap</a>, check their website for more technical info.'),


    /**
     *
     */
    'column_offset_1' => (new Select('Column offset', 'column_offset', '2001022141o'))
        ->set_choices([
            '0' => 'None',
            '1' => '1/12',
            '2' => '2/12',
            '3' => '3/12',
            '4' => '4/12',
            '5' => '5/12',
            '6' => '6/12',
            '7' => '7/12',
            '8' => '8/12',
        ])
        ->set_default_value('none')
        ->set_allow_null(false)
        ->set_instructions('Use this if you want to create space from the left edge or the previous column. The logic is the same as with column widths. For example, if you select "3/12", it is the equivalent of adding an empty 3/12 column before this column.<br><br>Keep in mind that the sum of the column width and offset should not be larger than 12. If you should for example create a 10/12 column with 4/12 offset, we will change the offset to 2. Likewise, if you create a column with offset set to 2 and width set to 4, you will have 6 (12 - (2+4)) units left on that row.'),

    /**
     *
     */
    'container_width_1' => (new Select('Container width', 'container_width', '2001291811a'))
        ->set_choices([
            'normal' => 'Normal',
            'full_width_with_margin' => 'Full width with margin',
            'full_width_without_margin' => 'Full width without margin',
        ]),

    /**
     *
     */
    'element_id' => (new Text('Element ID', 'element_id', '2001022234a'))
        ->set_instructions('If you want to create a deep link to this module, enter an ID for it here. You can then use this value when creating the link. Use only a-z, 0-9, _ and -.<br/>
<b>Note that when you want to link to the module, you need to prefix the value with #.</b> So if you enter "lorem" (without the quotes) here, the link should look like this: "#lorem" (again, without the quotes).<br>Also note that the id must be unique for the page that you are working on.'),

    /**
     *
     */
    'vertical_alignment' => (new Select('Vertical alignment', 'vertical_alignment', '2002031729a'))
        ->set_choices([
            'start' => 'Top',
            'center' => 'Center',
            'end' => 'Bottom',
        ])
        ->set_allow_null(false)
        ->set_instructions('Set the vertical alignment of the content in the columns.'),


];
