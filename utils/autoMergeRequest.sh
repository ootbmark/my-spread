#!/usr/bin/env bash
# Extract the host where the server is running, and add the URL to the APIs
[[ $HOST =~ ^https?://[^/]+ ]] && HOST="${BASH_REMATCH[0]}/api/v4/projects/"

# Look which is the default branch
TARGET_BRANCH="develop";

# The description of our new MR, we want to remove the branch after the MR has
# been closed
BODY="{
    \"id\": ${CI_PROJECT_ID},
    \"source_branch\": \"${CI_COMMIT_REF_NAME}\",
    \"target_branch\": \"${TARGET_BRANCH}\",
    \"remove_source_branch\": true,
    \"squash\": true,
    \"title\": \"${CI_COMMIT_REF_NAME}\",
    \"assignee_id\":\"${GITLAB_USER_ID}\",
    \"reviewer_ids\":\"[${GITLAB_USER_ID}]\"
}";

# Require a list of all the merge request and take a look if there is already
# one with the same source branch
LISTMR=`curl --silent "${HOST}${CI_PROJECT_ID}/merge_requests?state=opened" --header "PRIVATE-TOKEN:b2uyTcYdzx4Xpq3wMVyG"`;
COUNTBRANCHES=`echo ${LISTMR} | grep -o "\"source_branch\":\"${CI_COMMIT_REF_NAME}\"" | wc -l`;

# No MR found, let's create a new one
#if [ ${COUNTBRANCHES} -eq "0" ]; then
echo "${CI_COMMIT_REF_NAME}";
    curl -X POST "${HOST}${CI_PROJECT_ID}/merge_requests" \
        --header "PRIVATE-TOKEN:b2uyTcYdzx4Xpq3wMVyG" \
        --header "Content-Type: application/json" \
        --data "${BODY}";

    echo "Opened a new merge request: ${CI_COMMIT_REF_NAME} and assigned to you";
    exit;
#fi

echo "No new merge request opened";
