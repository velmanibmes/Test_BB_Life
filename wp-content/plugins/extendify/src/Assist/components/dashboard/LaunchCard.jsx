import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useTasksStore } from '@assist/state/tasks';

const launchSteps = {
	'site-type': {
		step: __('Site Industry', 'extendify-local'),
		title: __("Let's Start Building Your Website", 'extendify-local'),
		description: __(
			'Create a super-fast, beautiful, and fully customized site in minutes with our Site Launcher.',
			'extendify-local',
		),
		buttonText: __('Select Site Industry', 'extendify-local'),
	},
	'site-title': {
		step: __('Site Title', 'extendify-local'),
		title: __('Continue Building Your Website', 'extendify-local'),
		description: __(
			'Create a super-fast, beautiful, and fully customized site in minutes with our Site Launcher.',
			'extendify-local',
		),
		buttonText: __('Set Site Title', 'extendify-local'),
	},
	goals: {
		step: __('Goals', 'extendify-local'),
		title: __('Continue Building Your Website', 'extendify-local'),
		description: __(
			'Create a super-fast, beautiful, and fully customized site in minutes with our Site Launcher.',
			'extendify-local',
		),
		buttonText: __('Select Site Goals', 'extendify-local'),
	},
	'site-structure': {
		step: __('Site Structure', 'extendify-local'),
		title: __('Continue Building Your Website', 'extendify-local'),
		description: __(
			'Create a super-fast, beautiful, and fully customized site in minutes with our Site Launcher.',
			'extendify-local',
		),
		buttonText: __('Pick Your Site Structure', 'extendify-local'),
	},
	layout: {
		step: __('Design', 'extendify-local'),
		title: __('Continue Building Your Website', 'extendify-local'),
		description: __(
			'Create a super-fast, beautiful, and fully customized site in minutes with our Site Launcher.',
			'extendify-local',
		),
		buttonText: __('Select Site Design', 'extendify-local'),
	},
	pages: {
		step: __('Pages', 'extendify-local'),
		title: __('Continue Building Your Website', 'extendify-local'),
		description: __(
			'Create a super-fast, beautiful, and fully customized site in minutes with our Site Launcher.',
			'extendify-local',
		),
		buttonText: __('Select Site Pages', 'extendify-local'),
	},
};

const getCurrentLaunchStep = () => {
	const pageData = JSON.parse(
		localStorage.getItem(`extendify-pages-${window.extSharedData.siteId}`),
	) || { state: {} };
	const currentPageSlug = pageData?.state?.currentPageSlug;

	// If their last step doesn't exist in our options, just use step 1
	if (!Object.keys(launchSteps).includes(currentPageSlug)) {
		return 'site-type';
	}

	return currentPageSlug;
};

export const LaunchCard = ({ task }) => {
	const [currentStep, setCurrentStep] = useState();
	const { dismissTask } = useTasksStore();

	useEffect(() => {
		if (currentStep) return;
		setCurrentStep(getCurrentLaunchStep());
	}, [currentStep]);

	return (
		<div className="h-full justify-center overflow-hidden bg-white/95 text-base">
			<div className="flex h-full flex-col items-center justify-center gap-5 p-7 text-center md:p-8">
				{task?.htmlBefore()}
				<div className="flex h-full flex-col items-center justify-center text-center lg:justify-between">
					<div>
						<h2 className="mb-2 text-2xl font-semibold leading-10 md:mt-0 lg:text-2xl">
							{launchSteps[currentStep]?.title}
						</h2>
						<p className="m-0 text-sm md:text-base">
							{launchSteps[currentStep]?.description}
						</p>
					</div>
					<div className="cta mt-6 flex flex-wrap items-center text-sm md:gap-3 lg:mt-3">
						<a
							href={`${window.extSharedData.adminUrl}admin.php?page=extendify-launch`}
							className="min-w-24 cursor-pointer rounded-sm bg-design-main px-4 py-2.5 text-sm font-medium text-design-text no-underline hover:opacity-90">
							{launchSteps[currentStep]?.buttonText}
						</a>
						<button
							type="button"
							id="dismiss"
							onClick={() => {
								dismissTask('site-builder-launcher');
							}}
							className="cursor-pointer bg-transparent text-sm text-design-main underline-offset-4 hover:underline">
							{__('Dismiss', 'extendify-local')}
						</button>
					</div>
				</div>
			</div>
		</div>
	);
};
