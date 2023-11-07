pimcore.registerNS('SocialData.Connector.Youtube');
SocialData.Connector.Youtube = Class.create(SocialData.Connector.AbstractConnector, {

    hasCustomConfiguration: function () {
        return true;
    },

    getCustomConfigurationFields: function () {

        var data = this.customConfiguration;

        return [
            {
                trackResetOnLoad: true,
                xtype: 'textfield',
                name: 'apiKey',
                fieldLabel: 'API Key',
                allowBlank: false,
                value: data.hasOwnProperty('apiKey') ? data.apiKey : null
            }
        ];
    }
});