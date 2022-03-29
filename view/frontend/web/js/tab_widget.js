require(["jquery","mage/backend/tabs"], function($){
    $(function() {
        $('#tab_element').tabs({
            active: 'tab1_content',  // active tab elemtn id
            destination: '#tab_element_content', // tab content destination element id
            shadowTabs: []
        });
    });
});
