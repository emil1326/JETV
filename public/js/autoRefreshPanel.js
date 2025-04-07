let EndSessionAction = '/Accounts/Login';
class AutoRefreshedPanel {
    constructor(panelId, contentServiceURL, refreshRate, postRefreshCallback = null) {
        this.contentServiceURL = contentServiceURL;
        this.panelId = panelId;
        this.postRefreshCallback = postRefreshCallback;
        this.refreshRate = refreshRate * 1000; // => to ms to sec
        this.paused = false;
        this.remeinder = ""; // => for logs easier
        this.currentContent = "";  // initial content => gets from ajax
        if (refreshRate != 10101010) {
            // code for do not, if u dont want to refresh imidiatly when loading the script
            this.refresh();
            this.pause();
        }
        setInterval(() => { this.refresh() }, this.refreshRate);
    }

    pause() { this.paused = true }
    restart() { this.paused = false }

    replaceContent(htmlContent) {
        console.log(htmlContent);
        if (htmlContent !== "") {
            let parsedContent = $("<div>").html(htmlContent);
            let newContent = parsedContent.find("#" + this.panelId).html();

            if (newContent) {
                let cleanNewContent = newContent.replace(/<input name="__RequestVerificationToken".*?>/g, "");
                let cleanCurrentContent = this.currentContent.replace(/<input name="__RequestVerificationToken".*?>/g, "");

                // met a jour seulement si le contenu VRAIMENT utile a change
                if (cleanNewContent !== cleanCurrentContent) {
                    $("#" + this.panelId).html(newContent);
                    this.currentContent = newContent;
                    console.log(`Updated Content Div: ${this.panelId} : ${this.remeinder}`);
                } else {
                    console.log(`Content not updated, only CSRF token changed : ${this.panelId} : ${this.remeinder}`);
                }
            } else {
                console.log(`Failed to extract new content. ${this.panelId} : ${this.remeinder}`);
            }

            if (this.postRefreshCallback != null)
                this.postRefreshCallback();

        } else {
            console.log(`Received empty or undefined content. ${this.panelId} : ${this.remeinder}`);
        }
    }


    refresh(stillDo = false) {
        if (!this.paused || stillDo) {
            console.log(`refresh : ${this.panelId} : ${this.remeinder}`)
            $.ajax({
                url: this.contentServiceURL,
                dataType: "html",
                success: (htmlContent) => {
                    if (htmlContent != "blocked")
                        this.replaceContent(htmlContent);
                },
                statusCode: {
                    401: () => {
                        debugger
                        if (EndSessionAction != "")
                            window.location = EndSessionAction + "?message=Votre compte a été bloqué!&success=false";
                        else
                            alert("Illegal access!");
                    }
                }
            });
        }
    }

    command(url, moreCallBack = null) {
        $.ajax({
            url: url,
            method: 'GET',
            success: (params) => {
                this.refresh(true);
                if (moreCallBack != null)
                    moreCallBack(params);
            }
        });
    }

    confirmedCommand(message, url, moreCallBack = null) {
        bootbox.confirm(message, (result) => { if (result) this.command(url, moreCallBack) });
    }
}
