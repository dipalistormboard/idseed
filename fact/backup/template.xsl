<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	
	<!-- this tells FSF that our output is HTML (vs XML) -->
	<xsl:output method="html" />
	
	<!-- main template.  This processes the entire fact sheet currently being worked on -->
	<xsl:template match="/">
	<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"></xsl:text>
	<html>
		<head>
			<title>Factsheet - <xsl:value-of select="Entity/Name"/></title>
			
			<!-- include the scripts needed for our hover and popup behavior -->
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
			<script type="text/javascript" src="fs_images/autocolumn.min.js"></script>
			<script type="text/javascript" src="fs_images/PIE.js"></script>
			<script type="text/javascript" src="scripts.js"></script>
			
			<!-- CSS reset sheet to normalize browser behavior -->
			<!-- Note that FSF refuses to publish a second -->
			<!-- stylesheet, so we tuck it into the images directory -->
			<link rel="stylesheet" href="fs_images/reset.css" type="text/css" />
			
			<!-- stylesheets for our theme styles -->
			<link rel="stylesheet" href="template.css" type="text/css"/>
			
			<!-- print-specific stylesheet -->
			<link rel="stylesheet" href="fs_images/printable.css" type="text/css" media="print" />
	</head>
	<body>
		<xsl:if test="count(Entity/Media/Image/File) = 0">
			<xsl:attribute name="class">
				<xsl:text>no-image-bar</xsl:text>
			</xsl:attribute>
		</xsl:if>
		
		<div id="header">
			<div class="title">Identification Guide to Canadian Regulated Invasive Plant Seeds</div>
			<div class="cfia-logo">
				<img src="fs_images/cfia_logo.png" alt="Canadian Food Inspection Agency" width="224" height="20" />
			</div>
			<div class="search">
				<form action="http://www.google.com/search" method="get">
					<input type="text" name="q" size="15" /><input id="search-text" type="submit" value="Search" />
				</form>
			</div>
			<div class="header-image">
				<img src="fs_images/seed_header_2.jpg" alt="" width="349" height="161" />
			</div>
			<div class="language-selector">
				<ul>
					<li><a href="#">English Site</a></li>
					<li><a href="#">Fran<xsl:text disable-output-escaping="yes">&amp;ccedil;</xsl:text>ais Site</a></li>
				</ul>
			</div>
			<div class="menu">
				<ul>
					<li><a href="/">Home</a></li>
					<li><a href="index.htm">Fact Sheets</a></li>
					<li><a href="#">ID Keys</a></li>
					<li><a href="#">Gallery</a></li>
					<li><a href="#">Family Features</a></li>
					<li><a href="glossary.htm">Glossary</a></li>
				</ul>
			</div>
		</div>
		
		<!-- start our thumbnail area -->
		<xsl:if test="count(Entity/Media/Image/File) > 0">
		<div id="image-bar">
			<xsl:for-each select="Entity/Media/Image">
				
				<xsl:call-template name="leftThumbnail">
					<xsl:with-param name="fullURL" select="File" />
					<xsl:with-param name="thumbURL" select="Thumb" />
					<xsl:with-param name="caption" select="Caption" />
				</xsl:call-template>
			
			</xsl:for-each>
		</div>
		</xsl:if>
		<!-- end thumbnail area -->
		
		<!-- start body content -->
		<div id="content">
			<!-- main page title -->
			<h1><xsl:value-of disable-output-escaping="yes" select="Entity/Name" /></h1>
			
			<div class="columnize">
				<xsl:for-each select="Entity/Topic">
					<xsl:if test="Name != 'Similar Species'">
						<h2 class="dontend"><xsl:value-of select="Name"/></h2>
						<xsl:call-template name="globalReplace">
							<xsl:with-param name="outputString" select="Content" />
							<xsl:with-param name="target" select="'&amp;nbsp;'" />
							<xsl:with-param name="replacement" select="' '" />
						</xsl:call-template>
					</xsl:if>
				</xsl:for-each>
			</div>
			
			<!-- start related species box -->
			<xsl:for-each select="Entity/Topic">				
				<xsl:if test="Name = 'Similar Species'">
					<div id="related-species">
						<div class="images">
							<xsl:for-each select="//Entity/Media/Image">
							
								<xsl:call-template name="relatedThumbnail">
									<xsl:with-param name="fullURL" select="File" />
									<xsl:with-param name="thumbURL" select="Thumb" />
									<xsl:with-param name="caption" select="Caption" />
								</xsl:call-template>
							
							</xsl:for-each>
						</div>
						
						<h2><xsl:value-of select="Name"/></h2>
						<xsl:value-of select="Content" disable-output-escaping="yes"/>
						
						<div class="clear"></div>
					</div>
			  </xsl:if>
			</xsl:for-each>
			<!-- end related species box -->
			
		</div>
		<!-- end body content -->
		
		<!-- begin footer -->
		<div id="footer">
			<div class="medallion">
				<div class="logo">
					<img src="fs_images/canada_logo.png" alt="Canada" width="111" height="26" />
				</div>
				<div class="rights">
					Her Majesty the Queen in Right of Canada<br />
					Canadian Food Inspection Agency, all rights reserved
				</div>
			</div>
		</div>
		<!-- end footer -->
	</body>
	</html> 
	</xsl:template>
	
	<!-- begin template for a non-related-species thumbnail -->
	<xsl:template name="leftThumbnail">
		<xsl:param name="fullURL" />
		<xsl:param name="thumbURL" />
		<xsl:param name="caption" />
		
		<xsl:choose>
			<xsl:when test="not(contains($caption, 'Similar species'))">
				<div class="thumbnail-group">
					<div class="thumbnail">
						<a class="popup">
							<xsl:attribute name="href">
								<xsl:text></xsl:text><xsl:value-of select="$fullURL"/>
							</xsl:attribute>
							<img class="thumbnail">
								<xsl:attribute name="alt">
									<xsl:text />
								</xsl:attribute>
			
								<xsl:attribute name="src">
									<xsl:text></xsl:text>
									<xsl:value-of select="$thumbURL"/>
								</xsl:attribute>
								
								<xsl:attribute name="id">
									<xsl:text>image_</xsl:text><xsl:number format="1" />
								</xsl:attribute>
							</img></a>
					</div>
					<div class="caption">
						<xsl:call-template name="globalReplace">
							<xsl:with-param name="outputString" select="$caption" />
							<xsl:with-param name="target" select="'&amp;nbsp;'" />
							<xsl:with-param name="replacement" select="' '" />
						</xsl:call-template>
					</div>
				</div>
			</xsl:when>
		</xsl:choose>
		
	</xsl:template>
	<!-- end template for a non-related-species thumbnail -->
	
	<!-- begin template to render a related-species thumbnail -->
	<xsl:template name="relatedThumbnail">
		<xsl:param name="fullURL" />
		<xsl:param name="thumbURL" />
		<xsl:param name="caption" />

		<xsl:choose>
			<xsl:when test="contains($caption, 'Similar species')">
				<div class="thumbnail-group">
					<div class="thumbnail">
						<a class="popup">
							<xsl:attribute name="href">
								<xsl:text></xsl:text><xsl:value-of select="$fullURL"/>
							</xsl:attribute>
							<img class="thumbnail">
								<xsl:attribute name="alt">
									<xsl:text />
								</xsl:attribute>
			
								<xsl:attribute name="src">
									<xsl:text></xsl:text>
									<xsl:value-of select="$thumbURL"/>
								</xsl:attribute>
								
								<xsl:attribute name="id">
									<xsl:text>image_</xsl:text><xsl:number format="1" />
								</xsl:attribute>
							</img></a>
					</div>
					<div class="caption">
						<xsl:call-template name="globalReplace">
							<xsl:with-param name="outputString" select="$caption" />
							<xsl:with-param name="target" select="'&amp;nbsp;'" />
							<xsl:with-param name="replacement" select="' '" />
						</xsl:call-template>
					</div>
				</div>
			</xsl:when>
		</xsl:choose>
		
	</xsl:template>
	<!-- end template to render a related-species thumbnail -->
	
	<!-- search and replace template used to clean up/fix text that has strings in it we don't want-->
	<xsl:template name="globalReplace">
		<xsl:param name="outputString"/>
		<xsl:param name="target"/>
		<xsl:param name="replacement"/>
		
		<xsl:choose>
			<xsl:when test="contains($outputString,$target)">
				<xsl:value-of select="concat(substring-before($outputString,$target), $replacement)" disable-output-escaping="yes"/>
				<xsl:call-template name="globalReplace">
					<xsl:with-param name="outputString" select="substring-after($outputString,$target)"/>
					<xsl:with-param name="target" select="$target"/>
					<xsl:with-param name="replacement" select="$replacement"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$outputString" disable-output-escaping="yes"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<!-- end search and replace template -->
	
</xsl:stylesheet>
  
