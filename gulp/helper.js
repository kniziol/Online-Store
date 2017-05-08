module.exports = {
    /**
     * Type of assets.
     * Values of these properties are used in configuration while defining paths of assets.
     */
    assetType: {
        stylesheets: 'sass',
        javaScripts: 'js',
        images: 'images',
        fonts: 'fonts',
        videos: 'videos'
    },

    /**
     * Returns paths of assets for given type of assets and name of application's context.
     * Requires configuration object that contains paths, names of application's contexts etc.
     *
     * @param {Object} configuration Configuration object that contains paths, names of application's contexts etc.
     * @param {String} assetType Type of assets, e.g. "js". It should be one of properties defined in given configuration.
     * @param {String} contextName Name of application's context, e.g. "frontend"
     * @return {Array}
     */
    getAssetsPaths: function(configuration, assetType, contextName) {
        var paths = [];

        /*
         * Is given type of assets defined in given configuration?
         */
        if (configuration.assetCollection.hasOwnProperty(assetType)) {
            var allPaths = configuration.assetCollection[assetType];
            var commonContextName = configuration.application.commonContext;

            if (configuration.application.contexts.hasOwnProperty(contextName)) {
                /*
                 * Default options of each context
                 */
                var defaultOptions = {
                    /*
                     * Include assets from common application's context
                     */
                    includeCommonAssets: true
                };

                /*
                 * Prepare options of processed context by extending the default options
                 */
                var contextOptions = configuration.application.contexts[contextName];
                var options = this.extend(defaultOptions, contextOptions);

                /*
                 * Should assets from common application's context be included and is common application's context
                 * defined in object with assets in given configuration?
                 */
                if (options.includeCommonAssets && allPaths.hasOwnProperty(commonContextName)) {
                    paths = paths.concat(allPaths[commonContextName]);
                }

                /*
                 * Is given application's context defined in object with assets in given configuration?
                 */
                if (allPaths.hasOwnProperty(contextName)) {
                    paths = paths.concat(allPaths[contextName]);
                }

                /*
                 * Are there any paths?
                 */
                if (paths.length > 0) {
                    /*
                     * Let's make some string-based operations with the paths
                     */
                    for (var index in paths) {
                        /*
                         * Call of function hasOwnProperty() is required to avoid warning:
                         * Possible iteration over unexpected (custom / inherited) members, probably missing hasOwnProperty check
                         */
                        if (paths.hasOwnProperty(index)) {
                            var path = paths[index];
                            path = path.replace('{contextName}', contextName);

                            paths[index] = path;
                        }
                    }
                }
            }
        }

        return paths;
    },
    /**
     * Returns object2 merged with object1
     *
     * @param {Object} object1 The 1st original / default object
     * @param {Object} object2 The 2nd object
     * @return {*}
     */
    extend: function(object1, object2) {
        var result = {};

        for (var key in object1) {
            if (object1.hasOwnProperty(key)) {
                result[key] = object1[key];
            }
        }

        for (key in object2) {
            if (object2.hasOwnProperty(key)) {
                result[key] = object2[key];
            }
        }

        return result;
    }
};
