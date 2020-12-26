function emptyElement(element) {
    let child = element.firstChild;
    while(child) {
        child.remove();
        child = element.firstChild;        
    }
}