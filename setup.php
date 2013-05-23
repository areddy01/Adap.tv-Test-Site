<?PHP
$xmlstr = <<< XML
<?xml version='1.0' standalone='yes'?>
<config>
	<sectiontypes>
    	<type name="carousel" tablename="carousel" sortfield="sortorder" sorttype="manual" displaytype="active">
			<field dbfield="sortorder" datatype="int" length="11" required="false" listdisplay="order" />
			<field name="Background Image (960px by 444px)" dbfield="bgimage" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="true" listdisplay="none" />
			<field name="Layer 1 Image (960px by 444px up to 1500px by 444px)" dbfield="layer1image" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="false" />
			<field name="Layer 2 Image (960px by 444px up to 1500px by 444px)" dbfield="layer2image" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="false" />
			<field name="Layer 3 Image (960px by 444px up to 1500px by 444px)" dbfield="layer3image" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="false" />
			<field name="Layer 4 Image (960px by 444px up to 1500px by 444px)" dbfield="layer4image" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="false" />
			<field name="Headline" dbfield="title" datatype="text" fieldtype="multiline" length="multiline" required="true" listdisplay="none" />
            <field name="Tagline (red)" dbfield="highlighttext" datatype="text" fieldtype="multiline" required="false" listdisplay="none" />
			<field name="Call To Action" dbfield="ctatext" datatype="varchar" fieldtype="text" length="255" required="true" listdisplay="none" />
			<field name="Call To Action Link" dbfield="ctalink" datatype="varchar" fieldtype="text" length="255" required="true" listdisplay="none" />
			<field name="CTA Target" dbfield="ctatarget" datatype="varchar" fieldtype="select" length="255" required="true" listdisplay="none">
				<option value="_blank">Blank - New window</option>
				<option value="_top">Top - Outside iframe</option>
				<option value="_parent">Parent - Parent frame</option>
				<option value="_self">Self - Inside window</option>
			</field>   
			<field name="Tooltip (Tagline)" dbfield="tooltag" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="none" />
			<field name="Tooltip Title" dbfield="tooltitle" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="truncate=25" />         
			<field name="Video Link (optional)" dbfield="videolink" datatype="varchar" fieldtype="text" length="255" required="true" listdisplay="none" />
			<field name="Video Link Hit (x,y,width,height)" dbfield="videohit" datatype="varchar" fieldtype="text" length="255" required="true" listdisplay="none">
            	<default>0,0,0,0</default>
            </field>
			<field name="Display Time (In Seconds)" dbfield="displaytime" datatype="varchar" fieldtype="text" length="10" required="true" listdisplay="none">
            	<default>5</default>
            </field>
		</type>
		<type name="articles" tablename="articles" sortfield="date" sorttype="desc" displaytype="active">
			<field name="Title" dbfield="title" datatype="varchar" fieldtype="text" length="255" required="true" listdisplay="full" />
			<field name="Date" dbfield="date" datatype="date" fieldtype="date" required="true" listdisplay="datelabel" />
			<field name="Type (Press release, News Source, etc.)" dbfield="author" datatype="varchar" fieldtype="text" length="255" required="true" />
			<field name="Release Location (optional)" dbfield="location" datatype="varchar" fieldtype="text" length="255" required="true" />
			<field name="External Link (optional non press release)" dbfield="link" datatype="varchar" fieldtype="text" length="255" required="true" />
			<field name="Text" dbfield="text" datatype="text" fieldtype="html" length="20" required="true" />
		</type>
		<type name="leadershipbanner" tablename="leadershipbanner" sortfield="sortorder" sorttype="manual" displaytype="active">
			<field dbfield="sortorder" datatype="int" length="11" required="false" listdisplay="order" />
			<field name="Image (122px wide x 94px high)" dbfield="bgimage" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="true" listdisplay="image" />
			<field name="Leadership Box Title" dbfield="title" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="truncate=25">
            	<default>New Leadership Box</default>
            </field>
			<field name="Name" dbfield="name" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="none" />
			<field name="Position" dbfield="position" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="none" />
			<field name="Bio" dbfield="bio" datatype="text" fieldtype="multiline" length="3" max-length="180" required="true" listdisplay="none" />
			<field name="Call To Action" dbfield="ctatext" datatype="varchar" fieldtype="text" length="50" required="true" />
			<field name="Call To Action Link" dbfield="ctalink" datatype="varchar" fieldtype="text" length="255" required="true" />
			<field name="CTA Target" dbfield="ctatarget" datatype="varchar" fieldtype="select" length="255" required="true" listdisplay="none">
				<option value="_blank">Blank - New window</option>
				<option value="_top">Top - Outside iframe</option>
				<option value="_parent">Parent - Parent frame</option>
				<option value="_self">Self - Inside window</option>
			</field>
		</type>
		<type name="solutionsspotlight" tablename="solutionsspotlight" sortfield="sortorder" sorttype="manual" displaytype="active">
			<field dbfield="sortorder" datatype="int" length="11" required="false" listdisplay="order" />
			<field name="Image (122px wide x 94px high)" dbfield="bgimage" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="true" listdisplay="image" />
			<field name="Product/Solutions Box Title" dbfield="title" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="truncate=25">
            	<default>New Product/Solutions Box</default>
            </field>
			<field name="Name" dbfield="name" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="none" />
			<field name="Tagline" dbfield="position" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="none" />
			<field name="Description" dbfield="bio" datatype="text" fieldtype="multiline" length="3" max-length="180" required="true" listdisplay="none" />
			<field name="Call To Action" dbfield="ctatext" datatype="varchar" fieldtype="text" length="50" required="true" />
			<field name="Call To Action Link" dbfield="ctalink" datatype="varchar" fieldtype="text" length="255" required="true" />
			<field name="CTA Target" dbfield="ctatarget" datatype="varchar" fieldtype="select" length="255" required="true" listdisplay="none">
				<option value="_blank">Blank - New window</option>
				<option value="_top">Top - Outside iframe</option>
				<option value="_parent">Parent - Parent frame</option>
				<option value="_self">Self - Inside window</option>
			</field>
		</type>
		<type name="careerbanner" tablename="careerbanner" sortfield="sortorder" sorttype="manual" displaytype="active">
			<field dbfield="sortorder" datatype="int" length="11" required="false" listdisplay="order" />
			<field name="Image (122px wide x 94px high)" dbfield="bgimage" fieldtype="file={jpg,png,gif}" datatype="varchar" length="255" required="true" listdisplay="image" />
			<field name="Career Box Title" dbfield="title" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="truncate=25">
            	<default>New Career Box</default>
            </field>
			<field name="Job Title" dbfield="jobtitle" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="none" />
			<field name="Description" dbfield="description" datatype="text" fieldtype="multiline" length="2" max-length="70" required="true" listdisplay="none" />
			<field name="City/State" dbfield="citystate" datatype="varchar" fieldtype="text" length="16" required="true" listdisplay="none" />
			<field name="Country" dbfield="country" datatype="varchar" fieldtype="text" length="16" required="true" listdisplay="none" />
			<field name="Call To Action" dbfield="ctatext" datatype="varchar" fieldtype="text" length="50" required="true" />
			<field name="Call To Action Link" dbfield="ctalink" datatype="varchar" fieldtype="text" length="255" required="true" />
			<field name="CTA Target" dbfield="ctatarget" datatype="varchar" fieldtype="select" length="255" required="true" listdisplay="none">
				<option value="_blank">Blank - New window</option>
				<option value="_top">Top - Outside iframe</option>
				<option value="_parent">Parent - Parent frame</option>
				<option value="_self">Self - Inside window</option>
			</field>
		</type>
        
        <type name="articleplaceholder" tablename="articleplaceholder" sortfield="sortorder" sorttype="manual" displaytype="active" static="true">
			<field dbfield="sortorder" datatype="int" length="11" required="false" listdisplay="order" />
            <field name="Title" dbfield="title" datatype="varchar" fieldtype="text" length="50" required="true" listdisplay="full" />
        </type>
            
	</sectiontypes>    
	<sections>
		<content label="homepage">
			<name>Homepage</name>
			<fields></fields>
            <subsections>
				<content label="carousel">
					<name>Carousel</name>
					<contentoption type="Slide" sectionType="carousel" />
				</content>
            	<content label="homepage">
                    <name>Lower Third</name>
                    <fields></fields>
                    <options selectfield="publish" displaytype="active" sorttype="manual">
                        <contentoption type="Leadership Box" sectionType="leadershipbanner" />
                        <contentoption type="Career Box" sectionType="careerbanner" />
                        <contentoption type="Products/Solutions Box" sectionType="solutionsspotlight" />
                        <contentoption type="Article Box" sectionType="articleplaceholder" display="hidden" />
                    </options>
                </content>
           </subsections>
		</content>		
		<content label="articles">
			<name>Articles</name>
			<contentoption type="Article" sectionType="articles" />		
		</content>	
	</sections>
	<datasections></datasections>	
</config>
XML;
?>