<?php
    /* Libchart - PHP chart library
     * Copyright (C) 2005-2011 Jean-Marc Tr�meaux (jm.tremeaux at gmail.com)
     * 
     * This program is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 3 of the License, or
     * (at your option) any later version.
     * 
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License
     * along with this program.  If not, see <http://www.gnu.org/licenses/>.
     * 
     */
    
    /**
     * Chart composed of vertical bars.
     *
     * @author Jean-Marc Tr�meaux (jm.tremeaux at gmail.com)
     */
    class VerticalBarChart extends BarChart {
        /**
         * Ratio of empty space beside the bars.
         */
        private $emptyToFullRatio;
		public $vez = 1;

        /**
         * Creates a new vertical bar chart
         *
         * @param integer width of the image
         * @param integer height of the image
         */
        public function VerticalBarChart($width = 2000, $height = 800) {
            parent::BarChart($width, $height);

            $this->emptyToFullRatio = 1 / 5;
            $this->plot->setGraphPadding(new Padding(5, 260, 120, 50));
        }

        /**
         * Computes the layout.
         */
        protected function computeLayout() {
            if ($this->hasSeveralSerie) {
                $this->plot->setHasCaption(true);
            }
            $this->plot->computeLayout();
        }
        
        /**
         * Print the horizontal and veritcal axis.
         */
        protected function printAxis() {
            $minValue = $this->axis->getLowerBoundary();
            $maxValue = $this->axis->getUpperBoundary();
            $stepValue = $this->axis->getTics();

            // Get graphical obects
            $img = $this->plot->getImg();
            $palette = $this->plot->getPalette();
            $text = $this->plot->getText();
            
            // Get the graph area
            $graphArea = $this->plot->getGraphArea();
            
            // Vertical axis
            for ($value = $minValue; $value <= $maxValue; $value += $stepValue) {
                $y = $graphArea->y2 - ($value - $minValue) * ($graphArea->y2 - $graphArea->y1) / ($this->axis->displayDelta);

                imagerectangle($img, $graphArea->x1 - 3, $y, $graphArea->x1 - 2, $y + 1, $palette->axisColor[0]->getColor($img));
                imagerectangle($img, $graphArea->x1 - 1, $y, $graphArea->x1, $y + 1, $palette->axisColor[1]->getColor($img));

                $text->printText($img, $graphArea->x1 - 5, $y, $this->plot->getTextColor(), $value, $text->fontCondensed, $text->HORIZONTAL_RIGHT_ALIGN | $text->VERTICAL_CENTER_ALIGN);
            }

            // Get first serie of a list
            $pointList = $this->getFirstSerieOfList();

            // Horizontal Axis
            $pointCount = count($pointList);
            reset($pointList);
            $columnWidth = ($graphArea->x2 - $graphArea->x1) / $pointCount;
            for ($i = 0; $i <= $pointCount; $i++) {
                $x = $graphArea->x1 + $i * $columnWidth;

                imagerectangle($img, $x - 1, $graphArea->y2 + 2, $x, $graphArea->y2 + 3, $palette->axisColor[0]->getColor($img));
                imagerectangle($img, $x - 1, $graphArea->y2, $x, $graphArea->y2 + 1, $palette->axisColor[1]->getColor($img));

                if ($i < $pointCount) {
                    $point = current($pointList);
                    next($pointList);
    
                    $label = $point->getX();

                    $text->printDiagonal($img, $x + $columnWidth * 1 / 3, $graphArea->y2 + 10, $this->plot->getTextColor(), $label);
                }
            }
        }

        /**
         * Print the bars.
         */
        protected function printBar() {
            // Get the data as a list of series for consistency
            $serieList = $this->getDataAsSerieList();
            
            // Get graphical obects
            $img = $this->plot->getImg();
            $palette = $this->plot->getPalette();
            $text = $this->plot->getText();

            // Get the graph area
            $graphArea = $this->plot->getGraphArea();

            // Start from the first color for the first serie
            $barColorSet = $palette->barColorSet;
            $barColorSet->reset();

            $minValue = $this->axis->getLowerBoundary();
            $maxValue = $this->axis->getUpperBoundary();
            $stepValue = $this->axis->getTics();

            $serieCount = count($serieList);
            for ($j = 0; $j < $serieCount; $j++) {
                $serie = $serieList[$j];
                $pointList = $serie->getPointList();
                $pointCount = count($pointList);
                reset($pointList);

                // Select the next color for the next serie
                if (!$this->config->getUseMultipleColor()) {
                    $color = $barColorSet->currentColor();
                    $shadowColor = $barColorSet->currentShadowColor();
                    $barColorSet->next();
                }
				if($j==0)
					$this->vez = 1;
				if($j==1)
					$this->vez = 2;
                $columnWidth = ($graphArea->x2 - $graphArea->x1) / $pointCount;
                for ($i = 0; $i < $pointCount; $i++) {
					$this->vez == 1;
                    $x = $graphArea->x1 + $i * $columnWidth;

                    $point = current($pointList);
                    next($pointList);

                    $value = $point->getY();
                    
                    $ymin = $graphArea->y2 - ($value - $minValue) * ($graphArea->y2 - $graphArea->y1) / ($this->axis->displayDelta);

                    // Bar dimensions
                    $xWithMargin = $x + $columnWidth * $this->emptyToFullRatio;
                    $columnWidthWithMargin = $columnWidth * (1 - $this->emptyToFullRatio * 2);
                    $barWidth = $columnWidthWithMargin / $serieCount;
                    $barOffset = $barWidth * $j;
                    $x1 = $xWithMargin + $barOffset;
                    $x2 = $xWithMargin + $barWidth + $barOffset - 1;

                    // Select the next color for the next item in the serie
                    if ($this->config->getUseMultipleColor()) {
                        $color = $barColorSet->currentColor();
                        $shadowColor = $barColorSet->currentShadowColor();
                        $barColorSet->next();
                    }
                        
                    // Draw caption text on bar
					if($this->vez == 1)
					{
						if ($this->config->getShowPointCaption()) {
							setlocale(LC_MONETARY, 'en_US');
							$total = money_format('%.2n', $value);
							//$text->printText($img, ($x1 + $barWidth / 2) -8, $ymin - 5, $this->plot->getTextColor(), $total, $text->fontCondensed, 3 | $text->VERTICAL_BOTTOM_ALIGN);
							$text->printDiagonal($img, $x1 + $barWidth / 2,  $ymin - 5, $this->plot->getTextColor(), $total, $text->fontCondensed);
						}
					}
					else
					{
						if ($this->config->getShowPointCaption()) {
							setlocale(LC_MONETARY, 'en_US');
							$total = money_format('%.2n', $value);
							//$text->printText($img, ($x1 + $barWidth / 2) +7 , $ymin - 5, $this->plot->getTextColor(), $total, $text->fontCondensed, 2 | $text->VERTICAL_BOTTOM_ALIGN);
							$text->printDiagonal($img, $x1 + $barWidth / 2,  $ymin - 5, $this->plot->getTextColor(), $total, $text->fontCondensed);
						}
					}

                    // Draw the vertical bar
                    imagefilledrectangle($img, $x1, $ymin, $x2, $graphArea->y2 - 1, $shadowColor->getColor($img));

                    // Prevents drawing a small box when y = 0
                    if ($ymin != $graphArea->y2) {
                        imagefilledrectangle($img, $x1 + 1, $ymin + 1, $x2 - 4, $graphArea->y2 - 1, $color->getColor($img));
                    }
                }
            }
        }
        
        /**
         * Renders the caption.
         */
        protected function printCaption() {
            // Get the list of labels
            $labelList = $this->dataSet->getTitleList();
            
            // Create the caption
            $caption = new Caption();
            $caption->setPlot($this->plot);
            $caption->setLabelList($labelList);
            
            $palette = $this->plot->getPalette();
            $barColorSet = $palette->barColorSet;
            $caption->setColorSet($barColorSet);
            
            // Render the caption
            $caption->render();
        }

        /**
         * Render the chart image.
         *
         * @param string name of the file to render the image to (optional)
         */
        public function render($fileName = null) {
            // Check the data model
            $this->checkDataModel();
            
            $this->bound->computeBound($this->dataSet);
            $this->computeAxis();
            $this->computeLayout();
            $this->createImage();
            $this->plot->printLogo();
            $this->plot->printTitle();
            if (!$this->isEmptyDataSet(1)) {
                $this->printAxis();
                $this->printBar();
                if ($this->hasSeveralSerie) {
                    $this->printCaption();
                }
            }

            $this->plot->render($fileName);
        }
    }
?>