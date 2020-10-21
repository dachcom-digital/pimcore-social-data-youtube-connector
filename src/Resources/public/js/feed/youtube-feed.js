pimcore.registerNS('SocialData.Feed.Youtube');
SocialData.Feed.Youtube = Class.create(SocialData.Feed.AbstractFeed, {

    panel: null,

    getLayout: function () {

        this.panel = new Ext.form.FormPanel({
            title: false,
            defaults: {
                labelWidth: 200
            },
            items: this.getConfigFields()
        });

        return this.panel;
    },

    getConfigFields: function () {

        var fields = [];

        fields.push(
            {
                xtype: 'combo',
                value: this.data !== null ? this.data['fetchType'] : 'channel',
                fieldLabel: t('social_data.wall.feed.youtube.fetch_type'),
                name: 'fetchType',
                labelAlign: 'left',
                anchor: '100%',
                flex: 1,
                displayField: 'key',
                valueField: 'value',
                mode: 'local',
                triggerAction: 'all',
                queryDelay: 0,
                editable: false,
                summaryDisplay: true,
                allowBlank: false,
                store: new Ext.data.ArrayStore({
                    fields: ['value', 'key'],
                    data: [
                        ['playlist', 'Playlist ID'],
                        ['channel', 'Channel ID'],
                    ]
                })
            },
            {
                xtype: 'textfield',
                value: this.data !== null ? this.data['fetchValue'] : null,
                fieldLabel: t('social_data.wall.feed.youtube.fetch_value'),
                name: 'fetchValue',
                labelAlign: 'left',
                anchor: '100%',
                flex: 1
            },
            {
                xtype: 'numberfield',
                value: this.data !== null ? this.data['limit'] : null,
                fieldLabel: t('social_data.wall.feed.youtube.limit'),
                name: 'limit',
                maxValue: 500,
                minValue: 0,
                labelAlign: 'left',
                anchor: '100%',
                flex: 1
            }
        );

        return fields;
    },

    isValid: function () {
        return this.panel.form.isValid();
    },

    getValues: function () {
        return this.panel.form.getValues();
    }
});