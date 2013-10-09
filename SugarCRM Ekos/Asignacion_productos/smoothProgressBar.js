/*
 * smoothProgressBar.js
 *
 * Get the latest version from:
 *
 * http://www.jsclasses.org/smooth-progress-bar
 *
 * @(#) $Id: smoothProgressBar.js,v 1.7 2012/04/03 07:41:12 mlemos Exp $
 *
 *
 * This LICENSE is in the BSD license style.
 * *
 * Copyright (c) 2012, Manuel Lemos
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 *
 *   Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 *
 *   Neither the name of Manuel Lemos nor the names of his contributors
 *   may be used to endorse or promote products derived from this software
 *   without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

if(typeof(ML) === 'undefined')
	var ML = {};
if(typeof(ML.content) === 'undefined')
	ML.content = {};
ML.content.smoothProgressBar = function()
{
	var doNotRemoveThisGetTheLatestVersionFrom = 'http://www.jsclasses.org/smooth-progress-bar',
		thisObject = [],
		id = 0,
		poll = null;

	this.debug = false;
	this.style = 'position: absolute; width: 400px; text-align: center; left: 35%;';
	this.class = '';
	this.barStyle = 'background-color: #134270; padding: 2px;';
	this.barClass = '';
	this.barValueStyle = '';
	this.barValueClass = '';
	this.current = 0;
	this.total = 100;
	this.progressTemplate = '{progress}%';

	thisObject[++id] = this;
	this.currentBar = 0;
	this.currentWidth = 0;
	this.progressContainer = null;

	var outputDebug = function(o, message)
	{
		if(o.debug)
		{
			if(console
			&& console.log)
				console.log(message);
			else
				alert(message);
		}
		return false;
	};
	
	var getWindowSize = function()
	{
		if(document.body
		&& document.body.offsetWidth)
			return { width: document.body.offsetWidth, height: document.body.offsetHeight };
		if(document.compatMode == 'CSS1Compat'
		&& document.documentElement
		&& document.documentElement.offsetWidth)
			return { width: document.documentElement.offsetWidth, height: document.documentElement.offsetHeight };
		if(window.innerWidth
		&& window.innerHeight)
			return { width: window.innerWidth, height: window.innerHeight };
		return { width: 0, height: 0 };
	}

	var getElementSize = function(e, inner)
	{
		if(inner)
		{
			if(e.innerWidth)
				return { width: e.innerWidth, height: e.innerHeight }
			if(e.clientWidth)
				return { width: e.clientWidth, height: e.clientHeight }
		}
		else
		{
			if(typeof e.clip !== "undefined")
				return { width: e.clip.width, height: e.clip.height }
			if(e.style.pixelWidth)
				return { width: e.style.pixelWidth, height: e.style.pixelHeight }
		}
		return { width: e.offsetWidth, height: e.offsetHeight } 
	}

	var getElementPadding = function(e)
	{
		var s;

		if(e.currentStyle)
		{
			s = e.currentStyle;
			return { left: s['padding-left'], right: s['padding-right'], top: s['padding-top'], bottom: s['padding-bottom'] }
		}
		if(window.getComputedStyle)
		{
			s = document.defaultView.getComputedStyle(e, null);
			return { left: parseInt(s.getPropertyValue('padding-left')), right: parseInt(s.getPropertyValue('padding-right')),  top: parseInt(s.getPropertyValue('padding-top')), bottom: parseInt(s.getPropertyValue('padding-bottom'))  }
		}
		return { left: 0, right: 0 }
	}

	var updateProgressBar = function(o, force)
	{
		if(o.progressBar
		&& (force
		|| o.currentBar != o.current))
		{
			var s = getElementSize(o.progressContainer, true);
			var p = getElementPadding(o.progressContainer);
			s.width -= p.left + p.right;
			var p = getElementPadding(o.progressBar);
			s.width -= p.left + p.right;
			var target = Math.round(s.width * o.current / o.total);
			o.currentWidth = Math.max(0, Math.min(target, Math.round(o.currentWidth + (target - o.currentWidth) / 10 + (target > o.currentWidth ? 1 : -1))));
			o.progressBar.style.width = o.currentWidth + 'px';
			if(target === o.currentWidth)
				o.currentBar = o.current;
			return (o.currentBar != o.current);
		}
		return false;
	}

	var updateAllProgressBars = function()
	{
		var active = 0;

		for(id in thisObject)
		{
			o = thisObject[id];
			if(updateProgressBar(o, false))
				++active;
		}
		if(active === 0)
		{
			clearInterval(poll);
			poll = null;
		}
	}

	var updateProgress = function(o)
	{
		if(o.progressValue)
		{
			if(o.total <= 0)
				return outputDebug(o, 'it was not specified a valid total value ' +  o.total);
			if(o.current < 0
			|| o.current > o.total)
				return outputDebug(o, 'it was not specified a valid current progress value ' +  o.current);
			o.progressValue.innerHTML = o.progressTemplate.replace('{progress}', (100 * o.current / o.total));
			if(updateProgressBar(o, true)
			&& poll === null)
				poll = setInterval(updateAllProgressBars, 10);
		}
		return true;
	}

	this.openBar = function(options)
	{
		this.progressContainer = document.createElement('div');
		if(this.style.length)
			this.progressContainer.setAttribute('style', this.style);
		if(this.class.length)
			this.progressContainer.setAttribute('class', this.class);
		this.progressBar = document.createElement('div');
		if(this.barStyle.length)
			this.progressBar.setAttribute('style', this.barStyle);
		if(this.barClass.length)
			this.progressBar.setAttribute('class', this.barClass);
		this.progressValue = document.createElement('span');
		if(this.barValueStyle.length)
			this.progressValue.setAttribute('style', this.barValueStyle);
		if(this.barValueClass.length)
			this.progressValue.setAttribute('class', this.barValueClass);
		this.progressBar.appendChild(this.progressValue);
		this.progressContainer.appendChild(this.progressBar);
		document.body.appendChild(this.progressContainer);
		var ws = getWindowSize();
		var bs = getElementSize(this.progressContainer, false);
		this.progressContainer.style.left = (ws.width - bs.width) / 2;
		this.progressContainer.style.top = (ws.height - bs.height) / 2;
		updateProgress(this);
		return true;
	}

	this.closeBar = function()
	{
		if(!this.progressContainer)
			return false;
		document.body.removeChild(this.progressContainer);
		this.progressContainer = null;
		return true;
	}

	this.setProgress = function(progress)
	{
		if(progress < 0
		|| progress > this.total)
			return outputDebug(o, 'it was not specified a valid current progress value ' +  progress);
		this.current = progress;
		return updateProgress(this);
	}
}
