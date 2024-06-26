<?php 
/**
 * SSBBCodeParser
 *
 * BBCode parser classes.
 *
 * @copyright (C) 2011 Sam Clarke (samclarke.com)
 * @license https://www.gnu.org/licenses/lgpl.html LGPL version 3 or higher
 *
 * @TODO: Add inline/block to tags and forbid adding block elements to inline ones.
 * Maybe split the inline elemnt and put the block element inbetween?
 * @TODO: Have options for limiting nesting of tags
 * @TODO: Have whitespace trimming options for tags
 */

/*
 * This library is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <https://www.gnu.org/licenses/>.
 */

require('SBBCodeParser/Exception.php');
require('SBBCodeParser/Exception/MissingEndTag.php');
require('SBBCodeParser/Exception/InvalidNesting.php');

require('SBBCodeParser/Node.php');
require('SBBCodeParser/Node/Text.php');
require('SBBCodeParser/Node/Container.php');
require('SBBCodeParser/Node/Container/Tag.php');
require('SBBCodeParser/Node/Container/Document.php');

require('SBBCodeParser/BBCode.php');
