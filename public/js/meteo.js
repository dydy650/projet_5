

function Meteo(nantes) {
    this.nantes = nantes;
    this.citynameElt = $('#cityname');
    this.iconeDDElt = $('#iconeDD');
    this.tmpDDElt = $('#tmpDD');
    this.conditionDDElt = $('#conditionDD');
    this.wdnDDElt = $('#wdnDD');
    this.dayD1Elt = $('#dayD1');
    this.iconeD1Elt = $('#iconeD1');
    this.tmpD1minElt = $('#tmpD1min');
    this.tmpD1maxElt = $('#tmpD1max');
    this.dayD2Elt = $('#dayD2');
    this.iconeD2Elt = $('#iconeD2');
    this.tmpD2maxElt = $('#tmpD2max');
    this.tmpD2minElt = $('#tmpD2min');
    this.dayD3Elt = $('#dayD3');
    this.iconeD3Elt = $('#iconeD3');
    this.tmpD3minElt = $('#tmpD3min');
    this.tmpD3maxElt = $('#tmpD3max');
}
//création des méthodes

//mehode1:je remplie les infos
Meteo.prototype.fillInfo = function () {
    this.citynameElt.text(this.nantes.city_info.name);
    this.iconeDDElt.attr('src',this.nantes.current_condition.icon);
    this.tmpDDElt.text(this.nantes.current_condition.tmp+"°C");
    this.conditionDDElt.text(this.nantes.current_condition.condition);
    this.wdnDDElt.text("Vent : "+this.nantes.current_condition.wnd_spd+"km/h");

    this.dayD1Elt.text(this.nantes.fcst_day_1.day_short);
    this.iconeD1Elt.attr('src',this.nantes.fcst_day_1.icon);
    this.tmpD1minElt.text(this.nantes.fcst_day_1.tmin+"°C");
    this.tmpD1maxElt.text(this.nantes.fcst_day_1.tmax+"°C");

    this.dayD2Elt.text(this.nantes.fcst_day_2.day_short);
    this.iconeD2Elt.attr('src',this.nantes.fcst_day_2.icon);
    this.tmpD2minElt.text(this.nantes.fcst_day_2.tmin+"°C");
    this.tmpD2maxElt.text(this.nantes.fcst_day_2.tmax+"°C");

    this.dayD3Elt.text(this.nantes.fcst_day_3.day_short);
    this.iconeD3Elt.attr('src',this.nantes.fcst_day_3.icon);
    this.tmpD3minElt.text(this.nantes.fcst_day_3.tmin+"°C");
    this.tmpD3maxElt.text(this.nantes.fcst_day_3.tmax+"°C");
    console.log(this);
};
