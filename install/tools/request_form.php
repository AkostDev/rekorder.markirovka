<table x-data="requestForm">
    <tr x-show="success">
        <td colspan="2">
            <h3>Заявка успешно отправлена</h3>
        </td>
    </tr>
    <tr x-show="!success">
        <td style="width:30%;text-align:right">
            <label for="rm_name">Ваше имя:</label>
        </td>
        <td style="width:60%">
            <input type="text" id="rm_name" style="width:100%" x-model="name">
        </td>
    </tr>
    <tr x-show="!success">
        <td colspan="2"><br></td>
    </tr>
    <tr x-show="!success">
        <td style="width:30%;text-align:right">
            <label for="rm_phone">
                <b>Номер телефона для связи с вами:</b>
            </label>
        </td>
        <td style="width:60%">
            <input type="text" id="rm_phone" style="width:100%" x-mask="+7 (999) 999-99-99" x-model="phone">
        </td>
    </tr>
    <tr x-show="!success">
        <td>&nbsp;</td>
        <td style="width:60%">
            <br>
            <input type="button" value="Отправить заявку" @click="sendRequest">
        </td>
    </tr>
</table>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('requestForm', () => ({
            name: '',
            phone: '',
            success: false,

            async sendRequest() {
                if (this.phone.trim().length !== 18) {
                    alert('Неправильный формат номера телефона')

                    return
                }

                let response = await fetch("/bitrix/tools/rekorder.markirovka/request_form_ajax.php", {
                    method: 'POST',
                    body: JSON.stringify({
                        name: this.name,
                        phone: this.phone,
                    })
                }),
                    data = await response.json();

                this.success = data.success
            },
        }))
    })
</script>