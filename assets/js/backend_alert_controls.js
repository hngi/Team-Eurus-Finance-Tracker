
/**
 * @author Mofehintolu Mumuni for team Devpoint
 * @description Simple javascript helper functions to render timed alerts from the backend
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */

function cancel_timed_alert(element_id, interval_variable) {
    clearInterval(interval_variable);
    cancel_alert(element_id);
}


function generate_alert(error_message, element_id, text_color) {
    var ToElement = get_element(element_id);
    ToElement.innerHTML = error_message;
    ToElement.style.color = text_color;
}


function cancel_alert(element_id) {
    var ToElement = get_element(element_id);
    ToElement.innerHTML = "";
    ToElement.style.color = "";
}


function get_element(element_id) {
    var element = document.getElementById(element_id);
    return element;
}



