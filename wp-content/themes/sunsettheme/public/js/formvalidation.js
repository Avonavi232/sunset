/* Main form validation & control*/
/*Код надо бы пересмотреть, но вроде работает*/
let formValidation = (settings) => {

    let fields = [];
    let myForm = $(settings.myForm);
    myForm.find('input[name^="your-"]').each(function (i) {
        fields.push($(this));
    });
    myForm.find('textarea[name^="your-"]').each(function (i) {
        fields.push($(this));
    });
    let submitBtn = myForm.find( $(settings.submitBtn) );
    let errorContainerClass = settings.errorClass;
    let itemContainerClass = settings.itemClass;
    let disabledButtonClass = settings.disabledButtonClass;
    function getError(type){
        switch (type){
            case 'text':
                return 'The name is not correct!';
                break;
            case 'email':
                return 'The email is not correct';
                break;
            case 'tel':
                return 'The phone number is not correct';
                break;
            default:
                return 'Data entry error';
        }
    }

    function switchBtn(btn, switcher) {
        if(switcher){
            btn.prop('disabled', false).removeClass(disabledButtonClass);
        } else {
            btn.prop('disabled', true).addClass(disabledButtonClass);
        }
    }

    function addError(reg, self, type) {
        let error = getError(type);
        if( !((reg).test(self.val())) ){ //если регулярка не проверяется
            if( (self.parent().siblings('.' + errorContainerClass)).length < 1 ){ //если ошибка еще не выведена, то выведем
                self.closest('.' + itemContainerClass).append(`<div class="form-error">${error}</div>`);
            }
            switchBtn(submitBtn, 0); //выключим кнопку
        } else { //иначе, если регулярка проверяется, то ошибку удалим
            self.parent().siblings('.' + errorContainerClass).remove(); //Убирашка ошибки
            return false;
        }
    }
    function fieldCheck(type, self) {
        if(type === 'text'){
            addError(/^[a-zA-Z]{2,}/g, self, type);
        } else if(type === 'email'){
            addError(/(\w+|\d+)@\w+\.\w+/g, self, type);
        } else if(type === 'tel'){
            addError(/(^\+?)\d+\(?\d+\)?(\d+\-?)+$/, self, type)
        } else {
            addError(/\w+/, self, type);
        }
        // } else
        //     return false;
    }

    function formCheck() {
        for (let field of fields){

            let self = field;

            if( (self.prop('nodeName') === 'INPUT') || (self.prop('nodeName') === 'TEXTAREA') ) {
                let type = self.attr('type');
                fieldCheck(type, self);
            }
        }
    }

    switchBtn(submitBtn, 0); //disable the submit btn by default

    /*Добавляем каллбэк к каптче*/
    //$('.your-captchdeath').hide().attr('data-callback', 'myfunc');
    //(form.fields.container).append('<script>function myfunc(){ $(\'.contact-form \').submit();     }</script>');

    for (let field of fields){

        let self = field;

        if( (self.prop('nodeName') === 'INPUT') || (self.prop('nodeName') === 'TEXTAREA') ){
            let type = self.attr('type');
            fieldCheck(type, self); //проверим форму и добавим ошибки, и скроем их, чтоб они были, тогда кнопка деактивируется
            $('.form-error').hide();

            /*По блюру мы проверяем поле на правильность заполнения
            * Если ошибки во всей форме нет, то отображаем кнопку*/
            self.on('blur', () => {
                if(self.val() !== ''){
                    fieldCheck(type, self);
                }
                if ( (myForm.find('.form-error')).length === 0 ) {
                    switchBtn(submitBtn, 1);
                }
            }); //blur end


            /*По фокусу мы убираем ошибку в любом случае, предполагая, что сейчас начнется ввод*/
            self.on('focus', () => {
                self.parent().siblings('.' + errorContainerClass).remove(); //Убирашка ошибки
            }); //focus end

            /*По изменению поля мы проверяем его (помогло при отслеживании автозаполнения формы)*/
            self.on('change', ()=>{
                fieldCheck(type, self);
            });

            /*По кейпресу во время фокуса в поле мы проверяем поле на правильность.
            * Если ошибок во всей форме не обнаружено, отображаем кнопку
            * Если ошибки есть - скрываем кнопку.*/
            self.on('keypress', ()=>{
                fieldCheck(type, self);

                if( ( myForm.find('.' + errorContainerClass)).length === 0 ){
                    switchBtn(submitBtn, 1);
                } else {
                    switchBtn(submitBtn, 0);
                }
            });
        }
    }

    myForm.on('submit', ()=>{
        formCheck();
    });

    //добавляем капчу в cf7: [recaptcha class:your-captchdeath]


}; //end
formValidation({
    myForm: '.contact-form',
    submitBtn: '.contact-form__submit',
    errorClass: 'form-error',
    itemClass: 'contact-form__item',
    disabledButtonClass: 'contact-form__submit_disabled'
});
formValidation({
    myForm: '.subscribe-form__container',
    submitBtn: '.wpcf7-submit',
    errorClass: 'form-error',
    itemClass: 'subscribe-form__email',
    disabledButtonClass: 'submit_disabled'
});