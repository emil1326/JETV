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
        this.refresh();
        if (refreshRate == 10101010) {
            // code for do not, if u dont want to refresh imidiatly when loading the script
            this.pause();
        }
        setInterval(() => { this.refresh() }, this.refreshRate);
    }

    pause() { this.paused = true }
    restart() { this.paused = false }

    replaceContent(htmlContent) {
        // console.log(htmlContent);
        if (htmlContent !== "") {
            let parsedContent = $("<div>").html(htmlContent);
            let newContent = parsedContent.find("#" + this.panelId).html();

            if (newContent !== this.currentContent) {
                let cleanNewContent = newContent.replace(/<input name="__RequestVerificationToken".*?>/g, "");
                let cleanCurrentContent = this.currentContent.replace(/<input name="__RequestVerificationToken".*?>/g, "");

                // Update only if the content has changed
                if (cleanNewContent !== cleanCurrentContent) {
                    let currentElement = $("#" + this.panelId);
                    let newElement = $("<div>").html(newContent);

                    // Compare and update only the differences
                    this.setDifferenceInHtml(currentElement, newElement);

                    this.currentContent = newContent;
                    console.log(`Updated Content Div: ${this.panelId} : ${this.remeinder}`);
                } else {
                    console.log(`Content not updated, only CSRF token changed : ${this.panelId} : ${this.remeinder}`);
                }
            } else {
                if (!newContent)
                    console.log(`Failed to extract new content. ${this.panelId} : ${this.remeinder}`);
                else
                    console.log(`Same content received on ${this.panelId} : ${this.remeinder}`)
            }

            if (this.postRefreshCallback != null)
                this.postRefreshCallback();

        } else {
            console.log(`Received empty or undefined content. ${this.panelId} : ${this.remeinder}`);
        }
    }

    setDifferenceInHtml(currentElement, newElement) {
        // Iterate through the children of the current and new elements
        currentElement.contents().each((index, child) => {
            let currentChild = $(child);
            let newChild = newElement.contents().eq(index);

            if (newChild.length === 0) {
                // If the new child doesn't exist, remove the current child
                currentChild.remove();
            } else if (currentChild[0].nodeType === Node.TEXT_NODE && newChild[0].nodeType === Node.TEXT_NODE) {
                // If both are text nodes, compare and update the text
                if (currentChild.text() !== newChild.text()) {
                    currentChild.replaceWith(newChild.clone());
                }
            } else if (currentChild[0].nodeType === Node.ELEMENT_NODE && newChild[0].nodeType === Node.ELEMENT_NODE) {
                // If both are elements, recursively compare their children
                if (currentChild.prop("tagName") !== newChild.prop("tagName")) {
                    // If the tags are different, replace the entire element
                    currentChild.replaceWith(newChild.clone());
                } else {
                    // Recursively compare their children
                    this.setDifferenceInHtml(currentChild, newChild);
                }
            } else {
                // If the nodes are different types, replace the current child
                currentChild.replaceWith(newChild.clone());
            }
        });

        // Add any new children that don't exist in the current element
        newElement.contents().each((index, child) => {
            if (currentElement.contents().eq(index).length === 0) {
                currentElement.append($(child).clone());
            }
        });
    }

    refresh(stillDo = false) {
        if (!this.paused || stillDo) {
            // console.log(`refresh : ${this.panelId} : ${this.remeinder}`)
            if (document.hidden) {
                console.log(`Page is not visible. Skipping refresh for: ${this.panelId}`);
                return;
            }
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
