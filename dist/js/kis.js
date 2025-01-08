function karYagdir(karRengi, karSayisi) {
	var biltekKarAnim = document.getElementById("biltek--kis-anim");
	if (!biltekKarAnim && !document.body.classList.contains("kis_modu_yok")) {
		let embRand2 = function (min, max) {
				return Math.floor(Math.random() * (max - min + 1)) + min;
			},
			embRandColor2 = function () {
				/*var items = [
					"radial-gradient(circle at top left," +
						karRengi1 +
						"," +
						karRengi2 +
						")",
					karRengi3,
					karRengi4,
					karRengi5,
				];*/
				var items = [
					karRengi,
				];
				var item = items[Math.floor(Math.random() * items.length)];
				return item;
			};
		var embRand = embRand2,
			embRandColor = embRandColor2;
		var embCSS =
			".biltek-kis-anim{position: absolute;width: 10px;height: 10px;";
		//embCSS += "background: white;";
		embCSS +="border-radius: 50%;margin-top:-10px}";
		var embHTML = "";
		var karlar = [
			"❅",
			"❅",
			"❆",
			"❅",
			"❆",
			"❅",
			"❆",
		];
		for (i = 1; i < karSayisi; i++) {
			var kar = karlar[Math.floor(Math.random()*karlar.length)];
			embHTML += '<i class="biltek-kis-anim">'+kar+'</i>';
			var rndX = embRand2(0, 1e6) * 1e-4,
				rndO = embRand2(-1e5, 1e5) * 1e-4,
				rndT = (embRand2(3, 8) * 10).toFixed(2),
				rndS = (embRand2(0, 1e4) * 1e-4).toFixed(2);
			embCSS +=
				".biltek-kis-anim:nth-child(" +
				i +
				"){";
			/*embCSS += "background:" +
				embRandColor2() +
				";";
			embCSS += "opacity:" +
				(embRand2(1, 1e4) * 1e-4).toFixed(2) +
				";"*/
			embCSS += "transform:translate(" +
				rndX.toFixed(2) +
				"vw,-10px) scale(" +
				rndS +
				");animation:fall-" +
				i +
				" " +
				embRand2(10, 30) +
				"s -" +
				embRand2(0, 30) +
				"s linear infinite}@keyframes fall-" +
				i +
				"{" +
				rndT +
				"%{transform:translate(" +
				(rndX + rndO).toFixed(2) +
				"vw," +
				rndT +
				"vh) scale(" +
				rndS +
				")}to{transform:translate(" +
				(rndX + rndO / 2).toFixed(2) +
				"vw, 105vh) scale(" +
				rndS +
				")}}";
		}
		biltekKarAnim = document.createElement("div");
		biltekKarAnim.id = "biltek--kis-anim";
		biltekKarAnim.innerHTML =
			"<style>#biltek--kis-anim{position:fixed;left:0;top:0;bottom:0;width:100vw;height:100vh;overflow:hidden;z-index:9999999;pointer-events:none}" +
			embCSS +
			"</style>" +
			embHTML;
		document.body.appendChild(biltekKarAnim);
	}
}
