app.controller("TabController", function($scope) {
    this.tab = 2;

    this.setTab = function(tab){
        this.tab = tab;
    };

    this.isSet = function(tab){
        return (this.tab === tab);
    };
});