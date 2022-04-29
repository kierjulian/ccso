function discDiagDescription(description){
	var dischargeDiagDesc = document.getElementsByName('discDiagDesc')[0];
	var dischargeDiagDescription = document.getElementsByName('discDiagDescrip')[0];
	dischargeDiagDesc.value = description;
	dischargeDiagDescription.value = description;
	return;
}