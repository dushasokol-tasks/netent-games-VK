<?
/////////////////////////parser
/*
$str=explode('&',$output);
sort($str);
foreach($str as $e=>$v)
echo '$output.= "'.$v.'&";<br>';
*/
////////////////////////

$output .= "bl.i0.coins=20&";
$output .= "bl.i0.id=0&";
$output .= "bl.i0.line=0%2C0%2C0%2C0%2C0&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i1.coins=0&";
$output .= "bl.i1.id=1&";
$output .= "bl.i1.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i10.coins=0&";
$output .= "bl.i10.id=10&";
$output .= "bl.i10.line=3%2C2%2C1%2C1%2C1&";
$output .= "bl.i10.reelset=ALL&";
$output .= "bl.i11.coins=0&";
$output .= "bl.i11.id=11&";
$output .= "bl.i11.line=2%2C1%2C0%2C0%2C0&";
$output .= "bl.i11.reelset=ALL&";
$output .= "bl.i12.coins=0&";
$output .= "bl.i12.id=12&";
$output .= "bl.i12.line=0%2C1%2C0%2C1%2C0&";
$output .= "bl.i12.reelset=ALL&";
$output .= "bl.i13.coins=0&";
$output .= "bl.i13.id=13&";
$output .= "bl.i13.line=1%2C2%2C1%2C2%2C1&";
$output .= "bl.i13.reelset=ALL&";
$output .= "bl.i14.coins=0&";
$output .= "bl.i14.id=14&";
$output .= "bl.i14.line=2%2C3%2C2%2C3%2C2&";
$output .= "bl.i14.reelset=ALL&";
$output .= "bl.i15.coins=0&";
$output .= "bl.i15.id=15&";
$output .= "bl.i15.line=3%2C2%2C3%2C2%2C3&";
$output .= "bl.i15.reelset=ALL&";
$output .= "bl.i16.coins=0&";
$output .= "bl.i16.id=16&";
$output .= "bl.i16.line=2%2C1%2C2%2C1%2C2&";
$output .= "bl.i16.reelset=ALL&";
$output .= "bl.i17.coins=0&";
$output .= "bl.i17.id=17&";
$output .= "bl.i17.line=1%2C0%2C1%2C0%2C1&";
$output .= "bl.i17.reelset=ALL&";
$output .= "bl.i18.coins=0&";
$output .= "bl.i18.id=18&";
$output .= "bl.i18.line=0%2C1%2C0%2C0%2C0&";
$output .= "bl.i18.reelset=ALL&";
$output .= "bl.i19.coins=0&";
$output .= "bl.i19.id=19&";
$output .= "bl.i19.line=1%2C2%2C1%2C1%2C1&";
$output .= "bl.i19.reelset=ALL&";
$output .= "bl.i2.coins=0&";
$output .= "bl.i2.id=2&";
$output .= "bl.i2.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i20.coins=0&";
$output .= "bl.i20.id=20&";
$output .= "bl.i20.line=2%2C3%2C2%2C2%2C2&";
$output .= "bl.i20.reelset=ALL&";
$output .= "bl.i21.coins=0&";
$output .= "bl.i21.id=21&";
$output .= "bl.i21.line=3%2C2%2C3%2C3%2C3&";
$output .= "bl.i21.reelset=ALL&";
$output .= "bl.i22.coins=0&";
$output .= "bl.i22.id=22&";
$output .= "bl.i22.line=2%2C1%2C2%2C2%2C2&";
$output .= "bl.i22.reelset=ALL&";
$output .= "bl.i23.coins=0&";
$output .= "bl.i23.id=23&";
$output .= "bl.i23.line=1%2C0%2C1%2C1%2C1&";
$output .= "bl.i23.reelset=ALL&";
$output .= "bl.i24.coins=0&";
$output .= "bl.i24.id=24&";
$output .= "bl.i24.line=0%2C0%2C0%2C1%2C2&";
$output .= "bl.i24.reelset=ALL&";
$output .= "bl.i25.coins=0&";
$output .= "bl.i25.id=25&";
$output .= "bl.i25.line=1%2C1%2C1%2C2%2C3&";
$output .= "bl.i25.reelset=ALL&";
$output .= "bl.i26.coins=0&";
$output .= "bl.i26.id=26&";
$output .= "bl.i26.line=3%2C3%2C3%2C2%2C1&";
$output .= "bl.i26.reelset=ALL&";
$output .= "bl.i27.coins=0&";
$output .= "bl.i27.id=27&";
$output .= "bl.i27.line=2%2C2%2C2%2C1%2C0&";
$output .= "bl.i27.reelset=ALL&";
$output .= "bl.i28.coins=0&";
$output .= "bl.i28.id=28&";
$output .= "bl.i28.line=0%2C1%2C1%2C1%2C0&";
$output .= "bl.i28.reelset=ALL&";
$output .= "bl.i29.coins=0&";
$output .= "bl.i29.id=29&";
$output .= "bl.i29.line=1%2C2%2C2%2C2%2C1&";
$output .= "bl.i29.reelset=ALL&";
$output .= "bl.i3.coins=0&";
$output .= "bl.i3.id=3&";
$output .= "bl.i3.line=3%2C3%2C3%2C3%2C3&";
$output .= "bl.i3.reelset=ALL&";
$output .= "bl.i30.coins=0&";
$output .= "bl.i30.id=30&";
$output .= "bl.i30.line=2%2C3%2C3%2C3%2C2&";
$output .= "bl.i30.reelset=ALL&";
$output .= "bl.i31.coins=0&";
$output .= "bl.i31.id=31&";
$output .= "bl.i31.line=3%2C2%2C2%2C2%2C3&";
$output .= "bl.i31.reelset=ALL&";
$output .= "bl.i32.coins=0&";
$output .= "bl.i32.id=32&";
$output .= "bl.i32.line=2%2C1%2C1%2C1%2C2&";
$output .= "bl.i32.reelset=ALL&";
$output .= "bl.i33.coins=0&";
$output .= "bl.i33.id=33&";
$output .= "bl.i33.line=1%2C0%2C0%2C0%2C1&";
$output .= "bl.i33.reelset=ALL&";
$output .= "bl.i34.coins=0&";
$output .= "bl.i34.id=34&";
$output .= "bl.i34.line=0%2C1%2C1%2C0%2C1&";
$output .= "bl.i34.reelset=ALL&";
$output .= "bl.i35.coins=0&";
$output .= "bl.i35.id=35&";
$output .= "bl.i35.line=1%2C2%2C2%2C1%2C2&";
$output .= "bl.i35.reelset=ALL&";
$output .= "bl.i36.coins=0&";
$output .= "bl.i36.id=36&";
$output .= "bl.i36.line=2%2C3%2C3%2C2%2C3&";
$output .= "bl.i36.reelset=ALL&";
$output .= "bl.i37.coins=0&";
$output .= "bl.i37.id=37&";
$output .= "bl.i37.line=3%2C2%2C3%2C3%2C2&";
$output .= "bl.i37.reelset=ALL&";
$output .= "bl.i38.coins=0&";
$output .= "bl.i38.id=38&";
$output .= "bl.i38.line=2%2C1%2C2%2C2%2C1&";
$output .= "bl.i38.reelset=ALL&";
$output .= "bl.i39.coins=0&";
$output .= "bl.i39.id=39&";
$output .= "bl.i39.line=1%2C0%2C1%2C1%2C0&";
$output .= "bl.i39.reelset=ALL&";
$output .= "bl.i4.coins=0&";
$output .= "bl.i4.id=4&";
$output .= "bl.i4.line=0%2C1%2C2%2C1%2C0&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i5.coins=0&";
$output .= "bl.i5.id=5&";
$output .= "bl.i5.line=1%2C2%2C3%2C2%2C1&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i6.coins=0&";
$output .= "bl.i6.id=6&";
$output .= "bl.i6.line=3%2C2%2C1%2C2%2C3&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i7.coins=0&";
$output .= "bl.i7.id=7&";
$output .= "bl.i7.line=2%2C1%2C0%2C1%2C2&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i8.coins=0&";
$output .= "bl.i8.id=8&";
$output .= "bl.i8.line=0%2C1%2C2%2C2%2C2&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.i9.coins=0&";
$output .= "bl.i9.id=9&";
$output .= "bl.i9.line=1%2C2%2C3%2C3%2C3&";
$output .= "bl.i9.reelset=ALL&";
$output .= "clientaction=paytable&";
$output .= "pt.i0.comp.i0.freespins=0&";
$output .= "pt.i0.comp.i0.multi=2&";
$output .= "pt.i0.comp.i0.n=2&";
$output .= "pt.i0.comp.i0.symbol=SYM1&";
$output .= "pt.i0.comp.i0.type=betline&";
$output .= "pt.i0.comp.i1.freespins=0&";
$output .= "pt.i0.comp.i1.multi=15&";
$output .= "pt.i0.comp.i1.n=3&";
$output .= "pt.i0.comp.i1.symbol=SYM1&";
$output .= "pt.i0.comp.i1.type=betline&";
$output .= "pt.i0.comp.i10.freespins=0&";
$output .= "pt.i0.comp.i10.multi=40&";
$output .= "pt.i0.comp.i10.n=5&";
$output .= "pt.i0.comp.i10.symbol=SYM4&";
$output .= "pt.i0.comp.i10.type=betline&";
$output .= "pt.i0.comp.i11.freespins=0&";
$output .= "pt.i0.comp.i11.multi=10&";
$output .= "pt.i0.comp.i11.n=3&";
$output .= "pt.i0.comp.i11.symbol=SYM5&";
$output .= "pt.i0.comp.i11.type=betline&";
$output .= "pt.i0.comp.i12.freespins=0&";
$output .= "pt.i0.comp.i12.multi=20&";
$output .= "pt.i0.comp.i12.n=4&";
$output .= "pt.i0.comp.i12.symbol=SYM5&";
$output .= "pt.i0.comp.i12.type=betline&";
$output .= "pt.i0.comp.i13.freespins=0&";
$output .= "pt.i0.comp.i13.multi=40&";
$output .= "pt.i0.comp.i13.n=5&";
$output .= "pt.i0.comp.i13.symbol=SYM5&";
$output .= "pt.i0.comp.i13.type=betline&";
$output .= "pt.i0.comp.i14.freespins=0&";
$output .= "pt.i0.comp.i14.multi=10&";
$output .= "pt.i0.comp.i14.n=3&";
$output .= "pt.i0.comp.i14.symbol=SYM6&";
$output .= "pt.i0.comp.i14.type=betline&";
$output .= "pt.i0.comp.i15.freespins=0&";
$output .= "pt.i0.comp.i15.multi=20&";
$output .= "pt.i0.comp.i15.n=4&";
$output .= "pt.i0.comp.i15.symbol=SYM6&";
$output .= "pt.i0.comp.i15.type=betline&";
$output .= "pt.i0.comp.i16.freespins=0&";
$output .= "pt.i0.comp.i16.multi=40&";
$output .= "pt.i0.comp.i16.n=5&";
$output .= "pt.i0.comp.i16.symbol=SYM6&";
$output .= "pt.i0.comp.i16.type=betline&";
$output .= "pt.i0.comp.i17.freespins=0&";
$output .= "pt.i0.comp.i17.multi=5&";
$output .= "pt.i0.comp.i17.n=3&";
$output .= "pt.i0.comp.i17.symbol=SYM7&";
$output .= "pt.i0.comp.i17.type=betline&";
$output .= "pt.i0.comp.i18.freespins=0&";
$output .= "pt.i0.comp.i18.multi=10&";
$output .= "pt.i0.comp.i18.n=4&";
$output .= "pt.i0.comp.i18.symbol=SYM7&";
$output .= "pt.i0.comp.i18.type=betline&";
$output .= "pt.i0.comp.i19.freespins=0&";
$output .= "pt.i0.comp.i19.multi=20&";
$output .= "pt.i0.comp.i19.n=5&";
$output .= "pt.i0.comp.i19.symbol=SYM7&";
$output .= "pt.i0.comp.i19.type=betline&";
$output .= "pt.i0.comp.i2.freespins=0&";
$output .= "pt.i0.comp.i2.multi=30&";
$output .= "pt.i0.comp.i2.n=4&";
$output .= "pt.i0.comp.i2.symbol=SYM1&";
$output .= "pt.i0.comp.i2.type=betline&";
$output .= "pt.i0.comp.i20.freespins=0&";
$output .= "pt.i0.comp.i20.multi=5&";
$output .= "pt.i0.comp.i20.n=3&";
$output .= "pt.i0.comp.i20.symbol=SYM8&";
$output .= "pt.i0.comp.i20.type=betline&";
$output .= "pt.i0.comp.i21.freespins=0&";
$output .= "pt.i0.comp.i21.multi=10&";
$output .= "pt.i0.comp.i21.n=4&";
$output .= "pt.i0.comp.i21.symbol=SYM8&";
$output .= "pt.i0.comp.i21.type=betline&";
$output .= "pt.i0.comp.i22.freespins=0&";
$output .= "pt.i0.comp.i22.multi=20&";
$output .= "pt.i0.comp.i22.n=5&";
$output .= "pt.i0.comp.i22.symbol=SYM8&";
$output .= "pt.i0.comp.i22.type=betline&";
$output .= "pt.i0.comp.i23.freespins=0&";
$output .= "pt.i0.comp.i23.multi=5&";
$output .= "pt.i0.comp.i23.n=3&";
$output .= "pt.i0.comp.i23.symbol=SYM9&";
$output .= "pt.i0.comp.i23.type=betline&";
$output .= "pt.i0.comp.i24.freespins=0&";
$output .= "pt.i0.comp.i24.multi=10&";
$output .= "pt.i0.comp.i24.n=4&";
$output .= "pt.i0.comp.i24.symbol=SYM9&";
$output .= "pt.i0.comp.i24.type=betline&";
$output .= "pt.i0.comp.i25.freespins=0&";
$output .= "pt.i0.comp.i25.multi=20&";
$output .= "pt.i0.comp.i25.n=5&";
$output .= "pt.i0.comp.i25.symbol=SYM9&";
$output .= "pt.i0.comp.i25.type=betline&";
$output .= "pt.i0.comp.i26.freespins=0&";
$output .= "pt.i0.comp.i26.multi=5&";
$output .= "pt.i0.comp.i26.n=3&";
$output .= "pt.i0.comp.i26.symbol=SYM10&";
$output .= "pt.i0.comp.i26.type=betline&";
$output .= "pt.i0.comp.i27.freespins=0&";
$output .= "pt.i0.comp.i27.multi=10&";
$output .= "pt.i0.comp.i27.n=4&";
$output .= "pt.i0.comp.i27.symbol=SYM10&";
$output .= "pt.i0.comp.i27.type=betline&";
$output .= "pt.i0.comp.i28.freespins=0&";
$output .= "pt.i0.comp.i28.multi=20&";
$output .= "pt.i0.comp.i28.n=5&";
$output .= "pt.i0.comp.i28.symbol=SYM10&";
$output .= "pt.i0.comp.i28.type=betline&";
$output .= "pt.i0.comp.i29.freespins=5&";
$output .= "pt.i0.comp.i29.multi=0&";
$output .= "pt.i0.comp.i29.n=3&";
$output .= "pt.i0.comp.i29.symbol=SYM0&";
$output .= "pt.i0.comp.i29.type=scatter&";
$output .= "pt.i0.comp.i3.freespins=0&";
$output .= "pt.i0.comp.i3.multi=60&";
$output .= "pt.i0.comp.i3.n=5&";
$output .= "pt.i0.comp.i3.symbol=SYM1&";
$output .= "pt.i0.comp.i3.type=betline&";
$output .= "pt.i0.comp.i30.freespins=6&";
$output .= "pt.i0.comp.i30.multi=0&";
$output .= "pt.i0.comp.i30.n=4&";
$output .= "pt.i0.comp.i30.symbol=SYM0&";
$output .= "pt.i0.comp.i30.type=scatter&";
$output .= "pt.i0.comp.i31.freespins=7&";
$output .= "pt.i0.comp.i31.multi=0&";
$output .= "pt.i0.comp.i31.n=5&";
$output .= "pt.i0.comp.i31.symbol=SYM0&";
$output .= "pt.i0.comp.i31.type=scatter&";
$output .= "pt.i0.comp.i4.freespins=0&";
$output .= "pt.i0.comp.i4.multi=2&";
$output .= "pt.i0.comp.i4.n=2&";
$output .= "pt.i0.comp.i4.symbol=SYM3&";
$output .= "pt.i0.comp.i4.type=betline&";
$output .= "pt.i0.comp.i5.freespins=0&";
$output .= "pt.i0.comp.i5.multi=15&";
$output .= "pt.i0.comp.i5.n=3&";
$output .= "pt.i0.comp.i5.symbol=SYM3&";
$output .= "pt.i0.comp.i5.type=betline&";
$output .= "pt.i0.comp.i6.freespins=0&";
$output .= "pt.i0.comp.i6.multi=30&";
$output .= "pt.i0.comp.i6.n=4&";
$output .= "pt.i0.comp.i6.symbol=SYM3&";
$output .= "pt.i0.comp.i6.type=betline&";
$output .= "pt.i0.comp.i7.freespins=0&";
$output .= "pt.i0.comp.i7.multi=60&";
$output .= "pt.i0.comp.i7.n=5&";
$output .= "pt.i0.comp.i7.symbol=SYM3&";
$output .= "pt.i0.comp.i7.type=betline&";
$output .= "pt.i0.comp.i8.freespins=0&";
$output .= "pt.i0.comp.i8.multi=10&";
$output .= "pt.i0.comp.i8.n=3&";
$output .= "pt.i0.comp.i8.symbol=SYM4&";
$output .= "pt.i0.comp.i8.type=betline&";
$output .= "pt.i0.comp.i9.freespins=0&";
$output .= "pt.i0.comp.i9.multi=20&";
$output .= "pt.i0.comp.i9.n=4&";
$output .= "pt.i0.comp.i9.symbol=SYM4&";
$output .= "pt.i0.comp.i9.type=betline&";
$output .= "pt.i0.id=basic&";
$output .= "pt.i1.comp.i0.freespins=0&";
$output .= "pt.i1.comp.i0.multi=2&";
$output .= "pt.i1.comp.i0.n=2&";
$output .= "pt.i1.comp.i0.symbol=SYM1&";
$output .= "pt.i1.comp.i0.type=betline&";
$output .= "pt.i1.comp.i1.freespins=0&";
$output .= "pt.i1.comp.i1.multi=15&";
$output .= "pt.i1.comp.i1.n=3&";
$output .= "pt.i1.comp.i1.symbol=SYM1&";
$output .= "pt.i1.comp.i1.type=betline&";
$output .= "pt.i1.comp.i10.freespins=0&";
$output .= "pt.i1.comp.i10.multi=40&";
$output .= "pt.i1.comp.i10.n=5&";
$output .= "pt.i1.comp.i10.symbol=SYM4&";
$output .= "pt.i1.comp.i10.type=betline&";
$output .= "pt.i1.comp.i11.freespins=0&";
$output .= "pt.i1.comp.i11.multi=10&";
$output .= "pt.i1.comp.i11.n=3&";
$output .= "pt.i1.comp.i11.symbol=SYM5&";
$output .= "pt.i1.comp.i11.type=betline&";
$output .= "pt.i1.comp.i12.freespins=0&";
$output .= "pt.i1.comp.i12.multi=20&";
$output .= "pt.i1.comp.i12.n=4&";
$output .= "pt.i1.comp.i12.symbol=SYM5&";
$output .= "pt.i1.comp.i12.type=betline&";
$output .= "pt.i1.comp.i13.freespins=0&";
$output .= "pt.i1.comp.i13.multi=40&";
$output .= "pt.i1.comp.i13.n=5&";
$output .= "pt.i1.comp.i13.symbol=SYM5&";
$output .= "pt.i1.comp.i13.type=betline&";
$output .= "pt.i1.comp.i14.freespins=0&";
$output .= "pt.i1.comp.i14.multi=10&";
$output .= "pt.i1.comp.i14.n=3&";
$output .= "pt.i1.comp.i14.symbol=SYM6&";
$output .= "pt.i1.comp.i14.type=betline&";
$output .= "pt.i1.comp.i15.freespins=0&";
$output .= "pt.i1.comp.i15.multi=20&";
$output .= "pt.i1.comp.i15.n=4&";
$output .= "pt.i1.comp.i15.symbol=SYM6&";
$output .= "pt.i1.comp.i15.type=betline&";
$output .= "pt.i1.comp.i16.freespins=0&";
$output .= "pt.i1.comp.i16.multi=40&";
$output .= "pt.i1.comp.i16.n=5&";
$output .= "pt.i1.comp.i16.symbol=SYM6&";
$output .= "pt.i1.comp.i16.type=betline&";
$output .= "pt.i1.comp.i17.freespins=0&";
$output .= "pt.i1.comp.i17.multi=5&";
$output .= "pt.i1.comp.i17.n=3&";
$output .= "pt.i1.comp.i17.symbol=SYM7&";
$output .= "pt.i1.comp.i17.type=betline&";
$output .= "pt.i1.comp.i18.freespins=0&";
$output .= "pt.i1.comp.i18.multi=10&";
$output .= "pt.i1.comp.i18.n=4&";
$output .= "pt.i1.comp.i18.symbol=SYM7&";
$output .= "pt.i1.comp.i18.type=betline&";
$output .= "pt.i1.comp.i19.freespins=0&";
$output .= "pt.i1.comp.i19.multi=20&";
$output .= "pt.i1.comp.i19.n=5&";
$output .= "pt.i1.comp.i19.symbol=SYM7&";
$output .= "pt.i1.comp.i19.type=betline&";
$output .= "pt.i1.comp.i2.freespins=0&";
$output .= "pt.i1.comp.i2.multi=30&";
$output .= "pt.i1.comp.i2.n=4&";
$output .= "pt.i1.comp.i2.symbol=SYM1&";
$output .= "pt.i1.comp.i2.type=betline&";
$output .= "pt.i1.comp.i20.freespins=0&";
$output .= "pt.i1.comp.i20.multi=5&";
$output .= "pt.i1.comp.i20.n=3&";
$output .= "pt.i1.comp.i20.symbol=SYM8&";
$output .= "pt.i1.comp.i20.type=betline&";
$output .= "pt.i1.comp.i21.freespins=0&";
$output .= "pt.i1.comp.i21.multi=10&";
$output .= "pt.i1.comp.i21.n=4&";
$output .= "pt.i1.comp.i21.symbol=SYM8&";
$output .= "pt.i1.comp.i21.type=betline&";
$output .= "pt.i1.comp.i22.freespins=0&";
$output .= "pt.i1.comp.i22.multi=20&";
$output .= "pt.i1.comp.i22.n=5&";
$output .= "pt.i1.comp.i22.symbol=SYM8&";
$output .= "pt.i1.comp.i22.type=betline&";
$output .= "pt.i1.comp.i23.freespins=0&";
$output .= "pt.i1.comp.i23.multi=5&";
$output .= "pt.i1.comp.i23.n=3&";
$output .= "pt.i1.comp.i23.symbol=SYM9&";
$output .= "pt.i1.comp.i23.type=betline&";
$output .= "pt.i1.comp.i24.freespins=0&";
$output .= "pt.i1.comp.i24.multi=10&";
$output .= "pt.i1.comp.i24.n=4&";
$output .= "pt.i1.comp.i24.symbol=SYM9&";
$output .= "pt.i1.comp.i24.type=betline&";
$output .= "pt.i1.comp.i25.freespins=0&";
$output .= "pt.i1.comp.i25.multi=20&";
$output .= "pt.i1.comp.i25.n=5&";
$output .= "pt.i1.comp.i25.symbol=SYM9&";
$output .= "pt.i1.comp.i25.type=betline&";
$output .= "pt.i1.comp.i26.freespins=0&";
$output .= "pt.i1.comp.i26.multi=5&";
$output .= "pt.i1.comp.i26.n=3&";
$output .= "pt.i1.comp.i26.symbol=SYM10&";
$output .= "pt.i1.comp.i26.type=betline&";
$output .= "pt.i1.comp.i27.freespins=0&";
$output .= "pt.i1.comp.i27.multi=10&";
$output .= "pt.i1.comp.i27.n=4&";
$output .= "pt.i1.comp.i27.symbol=SYM10&";
$output .= "pt.i1.comp.i27.type=betline&";
$output .= "pt.i1.comp.i28.freespins=0&";
$output .= "pt.i1.comp.i28.multi=20&";
$output .= "pt.i1.comp.i28.n=5&";
$output .= "pt.i1.comp.i28.symbol=SYM10&";
$output .= "pt.i1.comp.i28.type=betline&";
$output .= "pt.i1.comp.i3.freespins=0&";
$output .= "pt.i1.comp.i3.multi=60&";
$output .= "pt.i1.comp.i3.n=5&";
$output .= "pt.i1.comp.i3.symbol=SYM1&";
$output .= "pt.i1.comp.i3.type=betline&";
$output .= "pt.i1.comp.i4.freespins=0&";
$output .= "pt.i1.comp.i4.multi=2&";
$output .= "pt.i1.comp.i4.n=2&";
$output .= "pt.i1.comp.i4.symbol=SYM3&";
$output .= "pt.i1.comp.i4.type=betline&";
$output .= "pt.i1.comp.i5.freespins=0&";
$output .= "pt.i1.comp.i5.multi=15&";
$output .= "pt.i1.comp.i5.n=3&";
$output .= "pt.i1.comp.i5.symbol=SYM3&";
$output .= "pt.i1.comp.i5.type=betline&";
$output .= "pt.i1.comp.i6.freespins=0&";
$output .= "pt.i1.comp.i6.multi=30&";
$output .= "pt.i1.comp.i6.n=4&";
$output .= "pt.i1.comp.i6.symbol=SYM3&";
$output .= "pt.i1.comp.i6.type=betline&";
$output .= "pt.i1.comp.i7.freespins=0&";
$output .= "pt.i1.comp.i7.multi=60&";
$output .= "pt.i1.comp.i7.n=5&";
$output .= "pt.i1.comp.i7.symbol=SYM3&";
$output .= "pt.i1.comp.i7.type=betline&";
$output .= "pt.i1.comp.i8.freespins=0&";
$output .= "pt.i1.comp.i8.multi=10&";
$output .= "pt.i1.comp.i8.n=3&";
$output .= "pt.i1.comp.i8.symbol=SYM4&";
$output .= "pt.i1.comp.i8.type=betline&";
$output .= "pt.i1.comp.i9.freespins=0&";
$output .= "pt.i1.comp.i9.multi=20&";
$output .= "pt.i1.comp.i9.n=4&";
$output .= "pt.i1.comp.i9.symbol=SYM4&";
$output .= "pt.i1.comp.i9.type=betline&";
$output .= "pt.i1.id=freespin&";
