<?php
namespace ARM\Armpdfkit\Pdf;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur Rahaman Mullick <anisur@armtechnologies.com>, ARM Technologies
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
// require_once('Fpdf.php');
// require_once('Fpdi.php');

/**
 *
 *
 * @package armpdfkit
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Pdf {
	
	/**
	 * @var \ARM\Armpdfkit\Pdf\Fpdf;
	 */
	public static $pdf;
	
	/**
	 * 
	 * @var \ARM\Armpdfkit\Pdf\FPDI
	 */
	public static $fpdi;
	
	/**
	 * 
	 * @param integer $x1
	 * @param integer $y1
	 * @param integer $x2
	 * @param integer $y2
	 */
	public static function drawLine($x1, $y1, $x2, $y2) {
		self::$pdf->Line($x1, $y1, $x2, $y2);	
	}
	
	/**
	 *
	 * @param array $data
	 * @param boolean $linebreak
	 * @param int $lineheight
	 * @param string $separator
	 * @return void
	 */
	public static function writeLine($data, $linebreak=FALSE, $lineheight=7, $separator=' ') {
		$line = '';
		if(is_array($data)) {
			foreach ($data as $column) {
				$line .= iconv("UTF-8", "UTF-16LE//IGNORE",$column).$separator;
			}
		}
		else {
			$line = iconv("UTF-8", "UTF-16LE//IGNORE", $data);
		}
		self::$pdf->Write($lineheight,self::_clean($line));
		if($linebreak == TRUE) {
			self::$pdf->Ln();
		}
	}
	
	/**
	 *
	 * @param string $data
	 * @param int $width
	 * @param int $height
	 * @param int $border
	 * @param boolean $linebreak
	 * @param string $align
	 * @param int $fill
	 * @param string $link
	 * @return void
	 */
	public static function writeCell($data, $width=10, $height=7, $border=1, $linebreak=0, $align='L', $fill=0, $link='', $multi=0, $factor=3) {
	
		$data = iconv("UTF-8", "UTF-16LE//IGNORE", $data);
		$data = self::_clean($data);
		if ($multi == 1) {
			$x = self::$pdf->GetX();
			$y = self::$pdf->GetY();
			self::$pdf->Cell($width, $height,'',$border);
			//CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $scale=0, $force=1)
			self::$pdf->SetX($x);
			self::$pdf->MultiCell($width, $height/$factor, $data, 0, $align, $fill);
			if ($linebreak == 0) {
				self::$pdf->SetY($y);
				self::$pdf->SetX($x + $width);
			}
			else {
				self::$pdf->SetY($y+$height);
			}
		}
		else {
			self::$pdf->Cell($width, $height, $data, $border, $linebreak, $align, $fill, $link);
		}
	}
	
	/**
	 *
	 * @param string $font
	 * @param int $size
	 * @param string $weight
	 */
	public static function setFont($font='Helvetica',$size,$weight='') {
		self::$pdf->SetFont($font,$weight,$size);
	}
	
	/**
	 * 
	 * @param \string $family
	 * @param \string $style
	 * @param \string $file
	 */
	public static function addFont($family, $style='', $file='') {
		self::$pdf->AddFont($family, $style, $file);
	}
	
	/**
	 * Instantiate the PDF class
	 * This to be called first
	 * @param char $orientation P/L
	 * @return void
	 */
	public static function init($orientation='P') {
		self::$pdf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ARM\\Armpdfkit\\Pdf\\Fpdf');
		self::$pdf->SetAutoPageBreak(true, 8);
		self::$pdf->AliasNbPages();
		self::$pdf->SetAuthor('Lern-Forum');
		self::$pdf->SetFont('helvetica','',8);
		self::$pdf->SetTextColor(0,0,0);
		self::$pdf->SetFillColor(225,225,225);
		self::$pdf->AddPage($orientation);
		self::$pdf->SetDisplayMode('real','default');
		self::$pdf->PDFVersion = '6.0';
	}
	
	/**
	 * 
	 * @param string $orientation
	 */
	public static function initFpdi($orientation='P')
	{
	    self::$fpdi = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ARM\\Armpdfkit\\Pdf\\Fpdi');
	    self::$fpdi->SetAutoPageBreak(true, 8);
	    self::$fpdi->SetAuthor('Lern-Forum');
	    self::$fpdi->SetFont('helvetica','',8);
	    self::$fpdi->SetTextColor(0,0,0);
	    self::$fpdi->SetFillColor(225,225,225);
	    self::$fpdi->AddPage($orientation);
	}
	
	/**
	 * 
	 * @param string $orientation
	 * @param string $size
	 */
	public static function addPage($orientation='', $size='') {
		self::$pdf->AddPage($orientation, $size);
	}
	
	/**
	 * 
	 * @param unknown $file
	 * @param string $x
	 * @param string $y
	 * @param number $w
	 * @param number $h
	 * @param string $type
	 * @param string $link
	 */
	public static function image($file, $x=null, $y=null, $w=0, $h=0, $type='', $link='') {
		self::$pdf->Image($file, $x, $y, $w, $h, $type, $link);
	}
	
	/**
	 *
	 * @param string $filename
	 * @param boolean $download
	 * @param string $path
	 * @throws \Exception
	 */
	public static function generatePDF($filename,$download=TRUE,$path=NULL)	{
			
		if ($download == TRUE) {
			self::$pdf->Output($filename,'D');
			exit();
		}
		else {
			if ($filename != '' && $path != '') {
				$file = $path.'/'.$filename;
				if (self::$pdf->Output($file,'F') === false) {
					throw new \Exception('ERROR: File not writable!');
				}
			}
			else {
				//return the buffer
				return self::$pdf->Output($filename,'S');
			}
		}
	}
	
	/**
	 * 
	 * @param \string $string
	 * @return mixed
	 */
	public static function _clean($string) {
	
		$string = preg_replace(
				array(
						'/\x00/', '/\x01/', '/\x02/', '/\x03/', '/\x04/'
				),
				'',
				$string
		);
		return $string;
	}
}