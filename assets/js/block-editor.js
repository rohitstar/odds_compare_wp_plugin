const { registerBlockType } = wp.blocks;
const { SelectControl, CheckboxControl } = wp.components;

registerBlockType('odds-compare/odds-block', {
    title: 'Odds Compare',
    icon: 'chart-line',
    category: 'widgets',
    attributes: {
        event: { type: 'string', default: 'test-event' },
        market: { type: 'string', default: 'match-winner' },
        bookmakers: { type: 'array', default: ['oddschecker'] },
        format: { type: 'string', default: 'decimal' },
    },
    edit: ({ attributes, setAttributes }) => {
        return (
            <div>
                <SelectControl
                    label="Market"
                    value={attributes.market}
                    options={[
                        { label: 'Match Winner', value: 'match-winner' },
                        { label: 'Over/Under', value: 'over-under' },
                    ]}
                    onChange={(market) => setAttributes({ market })}
                />
                <CheckboxControl
                    label="Oddschecker"
                    checked={attributes.bookmakers.includes('oddschecker')}
                    onChange={(checked) => {
                        const bookmakers = checked
                            ? [...attributes.bookmakers, 'oddschecker']
                            : attributes.bookmakers.filter((b) => b !== 'oddschecker');
                        setAttributes({ bookmakers });
                    }}
                />
                <SelectControl
                    label="Odds Format"
                    value={attributes.format}
                    options={[
                        { label: 'Decimal', value: 'decimal' },
                        { label: 'Fractional', value: 'fractional' },
                        { label: 'American', value: 'american' },
                    ]}
                    onChange={(format) => setAttributes({ format })}
                />
            </div>
        );
    },
    save: () => null,
});