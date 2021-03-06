<?php

/**
 * This file is part of Object Calisthenics
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_CodeSniffer-ObjectCalisthenics
 * @license  http://spdx.org/licenses/MIT MIT License
 * @version  GIT: master
 * @link     https://github.com/instaclick/ObjectCalisthenics
 */

/**
 * ObjectCalisthenics_Sniffs_Classes_SmallClassSniff.
 *
 * Keep classes (and methods) small
 *
 * @category PHP
 * @package  PHP_CodeSniffer-ObjectCalisthenics
 * @author   Anthon Pang <apang@softwaredevelopment.ca>
 * @license  http://spdx.org/licenses/MIT MIT License
 * @link     https://github.com/instaclick/ObjectCalisthenics
 */
class ObjectCalisthenics_Sniffs_Classes_SmallClassSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
    );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_CLASS, T_INTERFACE, T_TRAIT);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile All the tokens found in the document.
     * @param int                   $stackPtr  The position of the current token in
     *                                         the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $parser = new PHPParser_Parser(new PHPParser_Lexer);

        $visitor = new ObjectCalisthenics_Sniffs_Classes_SmallClassSniff_NodeVisitor;
        $visitor->setPHPCodeSnifferFile($phpcsFile);

        $traverser = new PHPParser_NodeTraverser;
        $traverser->addVisitor($visitor);

        try {
            $code = file_get_contents($phpcsFile->getFilename());
            $tree = $parser->parse($code);
            $tree = $traverser->traverse($tree);
        } catch (PHPParser_Error $e) {
        }
    }
}
