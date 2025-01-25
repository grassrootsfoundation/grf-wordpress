import { registerBlockType } from '@wordpress/blocks';
import { RichText, URLInputButton } from '@wordpress/block-editor';

registerBlockType('theme/hero-block', {
    title: 'Hero Block',
    icon: 'cover-image',
    category: 'design',
    attributes: {
        title: {
            type: 'string',
            source: 'html',
            selector: 'h1'
        },
        description: {
            type: 'string',
            source: 'html',
            selector: 'p'
        },
        buttonText: {
            type: 'string',
            default: 'Learn More'
        },
        buttonUrl: {
            type: 'string',
            default: '#'
        }
    },
    edit: ({ attributes, setAttributes }) => {
        const { title, description, buttonText, buttonUrl } = attributes;

        return (
            <div className="hero-block">
                <RichText
                    tagName="h1"
                    value={title}
                    onChange={(value) => setAttributes({ title: value })}
                    placeholder="Add a title..."
                />
                <RichText
                    tagName="p"
                    value={description}
                    onChange={(value) => setAttributes({ description: value })}
                    placeholder="Add a description..."
                />
                <div className="hero-button">
                    <RichText
                        tagName="span"
                        value={buttonText}
                        onChange={(value) => setAttributes({ buttonText: value })}
                        placeholder="Button Text"
                    />
                    <URLInputButton
                        url={buttonUrl}
                        onChange={(value) => setAttributes({ buttonUrl: value })}
                    />
                </div>
            </div>
        );
    },
    save: ({ attributes }) => {
        const { title, description, buttonText, buttonUrl } = attributes;

        return (
            <div className="hero-block">
                <h1>{title}</h1>
                <p>{description}</p>
                <a href={buttonUrl} className="hero-button">
                    {buttonText}
                </a>
            </div>
        );
    }
});